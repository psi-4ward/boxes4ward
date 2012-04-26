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


// GlobalContentelements switch
if($this->Input->get('do') == 'boxes4ward')
{
	$GLOBALS['TL_DCA']['tl_content']['config']['ptable'] = 'tl_boxes4ward_article';
	
	// set news4wards checkPermissions function
	$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('tl_content_boxes4ward', 'checkPermission');

	// set headerFields
	$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['headerFields'] = array('name');
	$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['header_callback'] = array('tl_content_boxes4ward','generateHeader');
	$GLOBALS['TL_DCA']['tl_content']['list']['operations']['toggle']['button_callback'] = array('tl_content_boxes4ward', 'toggleIcon');

}

class tl_content_boxes4ward extends tl_content
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Add Modulname to headerFields
	 * @param string $add
	 * @param DataContainer $dc
	 * @return array
	 */
	public function generateHeader($add, $dc)
	{
		$objModule = $this->Database->prepare('SELECT tl_module.name FROM tl_module
												LEFT JOIN tl_boxes4ward_article ON (tl_module.id = tl_boxes4ward_article.module_id)
												WHERE tl_boxes4ward_article.id=?')->execute(CURRENT_ID);

		$add[$GLOBALS['TL_LANG']['tl_boxes4ward_article']['module_id'][0]] = $objModule->name;

		return $add;
	}

	/**
	 * Check permissions to edit table tl_content
	 */
	public function checkPermission()
	{

		if ($this->User->isAdmin)
		{
			return;
		}

		
		if($this->Input->get('act'))
			$articleID = $this->Database->prepare('SELECT pid FROM tl_content WHERE id=?')->execute($this->Input->get('id'))->pid;
		else
			$articleID = $this->Input->get('id');


		// get archive id
		$objArchive = $this->Database->prepare('SELECT pid FROM tl_boxes4ward_article WHERE id=?')->execute($articleID);
		if($objArchive->numRows < 1 || !is_array($this->User->boxes4ward) || !in_array($objArchive->pid,$this->User->boxes4ward))
		{
			$this->log('Not enough permissions to '.$this->Input->get('act').' boxes4ward contentelement ID "'.$this->Input->get('id').'"', 'tl_content_boxes4ward checkPermission', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}
		
		
	}
}