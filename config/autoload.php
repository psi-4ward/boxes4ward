<?php

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


// Register the namespace
ClassLoader::addNamespace('Psi');

// Register the classes
ClassLoader::addClasses(array
(
	// Boxes4ward
	'Psi\Boxes4ward\Module\Boxes4ward' 	=> 'system/modules/boxes4ward/Module/Boxes4ward.php',

	// Models
	'Psi\Boxes4ward\Model\Article'  	=> 'system/modules/boxes4ward/Model/Article.php',
	'Psi\Boxes4ward\Model\Category'  	=> 'system/modules/boxes4ward/Model/Category.php',
));

// Register the templates
TemplateLoader::addFiles(array
(
	'mod_boxes4ward' 					=> 'system/modules/boxes4ward/templates',
));
