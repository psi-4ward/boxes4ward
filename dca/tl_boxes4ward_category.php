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
 * Table tl_boxes4ward_category
 */
$GLOBALS['TL_DCA']['tl_boxes4ward_category'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'					=> 'Table',
		'enableVersioning'				=> true,
		'ctable'						=> array('tl_boxes4ward_article'),
		'switchToEdit'					=> true,
		'onload_callback' 				=> array(array('tl_boxes4ward_category', 'checkPermission'))
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'						=> 1,
			'fields'					=> array('name'),
			'flag'						=> 1,
			'panelLayout'				=> 'filter;search,limit',
		),
		'label' => array
		(
			'fields'					=> array('name'),
			'format'					=> '%s',
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
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_category']['edit'],
				'href'					=> 'table=tl_boxes4ward_article',
				'icon'					=> 'edit.gif'
			),
			'editheader' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_category']['editheader'],
				'href'					=> 'act=edit',
				'icon'					=> 'header.gif'
			),
/* TODO: implement deep copy with articles and content-elements
			'copy' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_category']['copy'],
				'href'					=> 'act=copy',
				'icon'					=> 'copy.gif'
			),
			*/
			'delete' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_category']['delete'],
				'href'					=> 'act=delete',
				'icon'					=> 'delete.gif',
				'attributes'			=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_boxes4ward_category']['show'],
				'href'					=> 'act=show',
				'icon'					=> 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'						=> '{name_legend},name;{publish_legend},published,start,stop',
	),

	// Fields
	'fields' => array
	(
		'name' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_boxes4ward_category']['name'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
		),
	)
);


class tl_boxes4ward_category extends System
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
	 * Check permissions and hide categories user hasnt access
	 * @return void
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		// unset some actions
		$GLOBALS['TL_DCA']['tl_boxes4ward_category']['config']['closed'] = true;
		unset($GLOBALS['TL_DCA']['tl_boxes4ward_category']['list']['operations']['copy']);
		unset($GLOBALS['TL_DCA']['tl_boxes4ward_category']['list']['operations']['delete']);
		unset($GLOBALS['TL_DCA']['tl_boxes4ward_category']['list']['operations']['editheader']);

		if(!is_array($this->User->boxes4ward)) $this->User->boxes4ward = array();

		// Set filter to hide elemts user hastn access
		$GLOBALS['TL_DCA']['tl_boxes4ward_category']['list']['sorting']['filter'][] = array('FIND_IN_SET(id,?)',implode(',',$this->User->boxes4ward));

		if($this->Input->get('act') && $this->Input->get('act') != 'show')
		{
			$this->log('Only admin can '.$this->Input->get('act').' boxes4ward categories', 'tl_boxes4ward_category checkPermission', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}
	}
}