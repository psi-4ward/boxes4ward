<?php
namespace Psi\Boxes4ward\Module;


/**
 * Boxes4ward
 * Contao extension to manage articles and contentelement in content boxes
 *
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 * @licence LGPL
 * @filesource
 * @package Boxes4ward
 * @see https://github.com/psi-4ward/boxes4ward
 */


class Boxes4ward extends \Module
{

	/**
	* Template
	* @var string
	*/
	protected $strTemplate = 'mod_boxes4ward';


	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### Boxes4ward ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = $this->Environment->script.'?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	protected function compile()
	{
		// generate sql-WHERE
		$where = array();

		$where['module_id=?'] = $this->id;

		$where['(start="" OR start<?)'] = time();
		$where['(stop="" OR stop>?)'] = time();

		if(!BE_USER_LOGGED_IN)	$where['published=?'] = '1';

		// fetch articles
		$objArticle = $this->Database->prepare('SELECT * FROM tl_boxes4ward_article WHERE '.implode(' AND ',array_keys($where)).' ORDER BY sorting')->execute(array_values($where));
		if(!$objArticle->numRows) return;

		// filter articles to matching pages and generate its content elements
		$arrArticles = array();
		while($objArticle->next())
		{
			$objArticle->pages = deserialize($objArticle->pages,true);

			// check if the boxes4ward-article should displayed on the current page
			$pass = false;
			if(	    in_array($GLOBALS['objPage']->id,  $objArticle->pages) // page fits directly
				|| ($objArticle->inheritPages && count(array_intersect($GLOBALS['objPage']->trail, $objArticle->pages))) // inheritance and page fits an parent page
			)
			{
				$pass = true;
			}

			if($objArticle->reversePages && $pass)
			{
				// article should displayed but the logic is reversed
				continue;
			}
			elseif(!$objArticle->reversePages && !$pass)
			{
				// article should not displayed
				continue;
			}

			// check for month-filter
			if($objArticle->monthFilter && !(($monthes = deserialize($objArticle->monthes)) && in_array(date('n')-1,$monthes)))
			{
				continue;
			}

			// check for month-filter
			if($objArticle->weekdayFilter && !(($days = deserialize($objArticle->weekdays)) && in_array(date('w'),$days)))
			{
				continue;
			}

			$arrArticles[] = $objArticle->row();
		}

		// generate the articles
		$strContent = '';
		$intNumRows = count($arrArticles);
		foreach($arrArticles as $intCounter => $arrArticle)
		{
			// generate css classes (first,last,even,odd)
			$arrArticle['cssID'] = deserialize($arrArticle['cssID']);
			$class = 'boxes4ward_article';
			$class .= ($intCounter == 0) ? ' first' : '';
			$class .= ($intCounter == $intNumRows-1) ? ' last' : '';
			$class .= ($intCounter%2) ? ' odd' : ' even';

			// take the id/class from the article-attributes
			$id = '';
			if($arrArticle['cssID'])
			{
				if(strlen($arrArticle['cssID'][0]))
				{
					$id = ' id="'.$arrArticle['cssID'][0].'"';
				}

				if(strlen($arrArticle['cssID'][1]))
				{
					$class .= ' '.$arrArticle['cssID'][1];
				}
			}

			// add a div holding css id / classes
			$strContent .= sprintf('<div%s class="%s">',$id,$class);

			// fetch content elements and generate it
			$objCte = $this->Database->prepare("SELECT id FROM tl_content WHERE pid=?" . (!BE_USER_LOGGED_IN ? " AND invisible=''" : "") . " AND ptable='tl_boxes4ward_article' ORDER BY sorting")
									 ->execute($arrArticle['id']);

			while ($objCte->next())
			{
				$strContent .= $this->getContentElement($objCte->id);
			}
			
			$strContent .= '</div>';

		}

		$this->Template->content = $strContent;
	}
}

