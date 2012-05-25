<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


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


class ModuleBoxes4ward extends Module
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
			$objTemplate = new BackendTemplate('be_wildcard');

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
		$strContent = '';
		$intStyleCount = 1;
		while($objArticle->next())
		{
			$objArticle->pages = deserialize($objArticle->pages,true);
			$objArticle->cssID = deserialize($objArticle->cssID,true);

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

			// prepare the stlye div
			$strID 		= $objArticle->cssID[0] != '' ? 'id="'.$objArticle->cssID[0].'"' : '';
			$strClass 	= 'class="boxes4ward_item' . ($objArticle->cssID[1] != '' ? ' '.$objArticle->cssID[1] : '');
			
			if($objArticle->numRows>1)
			{
				switch($intStyleCount)
				{
					case 1:
						$strClass .= ' first'; 
					break;
					case $objArticle->numRows:
						$strClass .= ' last'; 
					break;
				}
				$intStyleCount++;
			}
			
			$strClass .= '"';
			$strContent .= sprintf('<div %s %s>', $strID, $strClass);
			
			// fetch content elements and generate it
			$objCte = $this->Database->prepare("SELECT id FROM tl_content WHERE pid=?" . (!BE_USER_LOGGED_IN ? " AND invisible=''" : "") . " AND do='boxes4ward' ORDER BY sorting")
									 ->execute($objArticle->id);

			while ($objCte->next())
			{
				$strContent .= $this->getContentElement($objCte->id);
			}
			
			$strContent .= '</div>';
		}

		$this->Template->content = $strContent;
	}
}

