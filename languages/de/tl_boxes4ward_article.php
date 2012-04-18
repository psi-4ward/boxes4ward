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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['name']			= array('Name', 'Bitte geben Sie den Artikelnamen ein.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['module_id']		= array('Modul', 'Der Artikel wird in diesem Modul eingefügt.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['pages']			= array('Seiten', 'Auf diesen Seiten wird die Box angezeigt.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['reversePages']	= array('Seitenauswahl-Logik umkehren', 'Ausgewählte Seiten werden *nicht* angezeigt. Auswahl hier und keine der Seiten aktiv ist gleichbedeutend mit "alle Seiten".');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['inheritPages']	= array('Unterseiten wählen', 'Die Box wird zusätzlich auf allen Unterseiten angezeigt.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['published']		= array('Artikel veröffentlichen', 'Den Artikel auf der Webseite anzeigen.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['start']			= array('Anzeigen ab', 'Den Artikel erst ab diesem Tag auf der Webseite anzeigen.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['stop']			= array('Anzeigen bis', 'Den Artikel nur bis zu diesem Tag auf der Webseite anzeigen.');


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['new']				= array('Neue Artikel', 'Erstellen Sie eine neue Artikel im Dashboard');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['edit']			= array('Inhaltselemente bearbeiten', 'Die Inhaltselemente des Artikels ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['editheader']		= array('Artikel bearbeiten', 'Artikels ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['copy']			= array('Artikel kopieren', 'Artikel ID %s kopieren');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['cut']				= array('Artikel verschieben', 'Artikel ID %s verschieben');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['delete']			= array('Artikel löschen', 'Artikel ID %s löschen');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['show']			= array('Artikelendetails', 'Details der Artikel ID %s anzeigen');



/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['name_legend']		= 'Name';
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['config_legend']	= 'Einstellungen';
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['publish_legend']	= 'Veröffentlichung';

