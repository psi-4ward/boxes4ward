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
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] = str_replace('formp;', 'formp;{boxes4ward_legend},boxes4ward,boxes4ward_newp;', $GLOBALS['TL_DCA']['tl_user']['palettes']['extend']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] = str_replace('formp;', 'formp;{boxes4ward_legend},boxes4ward,boxes4ward_newp;', $GLOBALS['TL_DCA']['tl_user']['palettes']['custom']);


/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user']['fields']['boxes4ward'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['boxes4ward'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_boxes4ward_category.name',
	'eval'                    => array('multiple'=>true),
	'sql'					  => 'blob NULL'
);
$GLOBALS['TL_DCA']['tl_user']['fields']['boxes4ward_newp'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['boxes4ward_newp'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('create', 'delete'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('multiple'=>true),
	'sql'					  => 'blob NULL'
);