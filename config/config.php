<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


// BE-Module
$GLOBALS['BE_MOD']['content']['boxes4ward'] = array(
	'tables'  => array('tl_boxes4ward_category','tl_boxes4ward_article','tl_content'),
	'icon'    => 'system/modules/boxes4ward/html/icon.png'
);



// FE-Modules
$GLOBALS['FE_MOD']['miscellaneous']['boxes4ward'] = 'ModuleBoxes4ward';


// add news archive permissions
$GLOBALS['TL_PERMISSIONS'][] = 'boxes4ward';