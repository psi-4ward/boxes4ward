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


// BE-Module
$GLOBALS['BE_MOD']['content']['boxes4ward'] = array(
	'tables'  => array('tl_boxes4ward_category','tl_boxes4ward_article','tl_content'),
	'icon'    => 'system/modules/boxes4ward/html/icon.png'
);



// FE-Modules
$GLOBALS['FE_MOD']['miscellaneous']['boxes4ward'] = 'ModuleBoxes4ward';


// add news archive permissions
$GLOBALS['TL_PERMISSIONS'][] = 'boxes4ward';
$GLOBALS['TL_PERMISSIONS'][] = 'boxes4ward_newp';