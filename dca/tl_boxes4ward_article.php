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
 

 /**
  * Table tl_boxes4ward_article
  */
$GLOBALS['TL_DCA']['tl_boxes4ward_article'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'					=> 'Table',
		'enableVersioning'				=> true,
		'ptable'						=> 'tl_boxes4ward_category',
		'ctable'						=> array('tl_content'),
		'switchToEdit'					=> true,
		'onload_callback' 			  	=> array(array('tl_boxes4ward_article', 'checkPermission'))
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'						=> 4,
			'fields'					=> array('sorting'),
			'panelLayout'				=> 'filter;search,limit',
			'headerFields'            	=> array('name'),
			'child_record_callback'   	=> array('tl_boxes4ward_article', 'listItem')
		),
		'label' => array
		(
			'fields'					=> array('name','module_id:tl_module.name'),
			'format'					=> '%s &nbsp; <span style=;color:#666666">[%s]</span>',
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'					=> 'act=select',
				'class'					=> 'header_edit_all',
				'attributes'			=> 'onclick="Backend.getScrollOffset();" accesskey="e"'
			),
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['edit'],
				'href'					=> 'table=tl_content',
				'icon'					=> 'edit.gif'
			),
			'editheader' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['editheader'],
				'href'					=> 'act=edit',
				'icon'					=> 'header.gif'
			),
			'copy' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['copy'],
				'href'					=> 'act=copy',
				'icon'					=> 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset()"'
			),
			'delete' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['delete'],
				'href'					=> 'act=delete',
				'icon'					=> 'delete.gif',
				'attributes'			=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
		 	'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('DCAHelper', 'toggleIcon')
			),
			'show' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['show'],
				'href'					=> 'act=show',
				'icon'					=> 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'						=> '{name_legend},name,module_id;{config_legend},pages,reversePages,inheritPages;{publish_legend},published,start,stop',
	),

	// Fields
	'fields' => array
	(
		'name' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['name'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'search'					=> true,
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
		),
		'pages' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['pages'],
			'inputType'               => 'pageTree',
			'eval'                    => array("multiple"=>true, 'fieldType'=>'checkbox')
		),
		'module_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['module_id'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'filter'                  => true,
			'options_callback'        => array('tl_boxes4ward_article', 'getModules'),
			'eval'                    => array('helpwizard'=>true, 'tl_class'=>'w50')
		),
		'reversePages' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['reversePages'],
			'exclude'                 => true,
			'filter'				  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'inheritPages' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['inheritPages'],
			'exclude'                 => true,
			'filter'				  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50')
		),
		'published' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['published'],
			'exclude'					=> true,
			'filter'					=> true,
			'inputType'					=> 'checkbox',
			'eval'						=> array('doNotCopy'=>true),
		),
		'start' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['start'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'stop' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['stop'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		)
	)
);


class tl_boxes4ward_article extends System
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
		$this->import('Database');
	}


	/**
	 * Generate listItem
	 * @param array
	 * @return string
	 */
	public function listItem($arrRow)
	{
		$objModule = $this->Database->prepare('SELECT name FROM tl_module WHERE id=?')->execute($arrRow['module_id']);
		if($objModule->numRows) $arrRow['module_id'] = $objModule->name;
		return '<div class="">' . $arrRow['name'] . '<br><span style="color:#999;font-family:mono;">['. $arrRow['module_id'] .']</span></div>' . "\n";
	}


	/**
	 * Get Moduls with type boxes4ward
	 * @param array
	 * @return string
	 */
	public function getModules()
	{
		$arrModuls = array();
		$objModuls = $this->Database->prepare("SELECT * FROM tl_module WHERE type=?")->execute("boxes4ward");

		while($objModuls->next())
		{
			$arrModuls[$objModuls->id] = $objModuls->name;
		}

		return $arrModuls;
	}

	/**
	 * Restrict access to the boxes4ward article
	 *
	 * @param $dc
	 * @return mixed
	 */
	public function checkPermission($dc)
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		if(!is_array($this->User->boxes4ward))
		{
			$this->log('User has no access to any boxes4ward category', 'tl_boxes4ward_category checkPermission', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		if(!$this->Input->get('act') && !in_array($this->Input->get('id'),$this->User->boxes4ward))
		{
			$this->log('User has no access to view boxes4ward category ID:'.$this->Input->get('id'), 'tl_boxes4ward_category checkPermission', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}


		if($this->Input->get('act'))
		{
			// get pid
			if($this->Input->get('pid'))
			{
				$pid = $this->Input->get('pid');
			}
			else
			{
				$obj = $this->Database->prepare('SELECT pid FROM tl_boxes4ward_article WHERE id=?')->execute($this->Input->get('id'));
				$pid = $obj->pid;

			}

			if(!in_array($pid,$this->User->boxes4ward))
			{
				$this->log('User has no access to view boxes4ward category ID:'.$pid, 'tl_boxes4ward_category checkPermission', TL_ERROR);
				$this->redirect('contao/main.php?act=error');
			}
		}
	}

}
