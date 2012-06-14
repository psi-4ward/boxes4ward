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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Boxes4ward
	'Boxes4ward\ModuleBoxes4ward' => 'system/modules/boxes4ward/classes/ModuleBoxes4ward.php',

	// Models
	'Boxes4ward\Boxes4wardArticleModel'  => 'system/modules/boxes4ward/models/Boxes4wardArticleModel.php',
	'Boxes4ward\Boxes4wardCategoryModel'  => 'system/modules/boxes4ward/models/Boxes4wardCategoryModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_boxes4ward' => 'system/modules/boxes4ward/templates',
));
