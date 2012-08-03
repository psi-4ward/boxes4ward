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
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['name']			= array('Name', 'Please add an article name.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['module_id']		= array('Module', 'The Article takes place in this module.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['pages']			= array('Pages', 'The box will show up on these pages.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['reversePages']	= array('Invert page-choice logic', 'Selected pages will not show up. Selecting this an no page is equal to "All Pages".');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['inheritPages']	= array('Choose subpages', 'The Box will show up on subpages, too.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['weekdayFilter']	= array('Limit to weekdays', 'The Box will shown up only on selected weekdays.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['weekdays']		= array('Weekdays', 'Choose the weekdays the box will be shown up.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['monthFilter']		= array('Limit to monthes', 'The Box will shown up only on selected monthes.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['monthes']			= array('Monthes', 'Choose the monthes the box will be shown up.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['cssID']         	= array('CSS ID/class', 'Here you can set an ID and one or more classes.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['published']		= array('Publish article', 'Show the article on the website.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['start']			= array('Show from', 'Shows the article from this date on.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['stop']			= array('Show till', 'Shows the article until this date.');


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['new']				= array('New article', 'Create a new article in the dashboard.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['edit']			= array('Edit content element', 'Edit the content elements of the article with ID %s.');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['editheader']		= array('Edit article', 'Edit article ID %s');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['copy']			= array('Copy article', 'Copy article ID %s');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['cut']				= array('Move article', 'Move article ID %s');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['delete']			= array('Delete article', 'Delete artice ID %s');
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['show']			= array('Articledetails', 'Show up details of article ID %s.');



/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['name_legend']		= 'Name';
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['config_legend']	= 'Settings';
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['weekday_legend']	= 'Limit to weekdays';
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['month_legend']	= 'Limit to monthes';
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['expert_legend']   = 'Expert settings';
$GLOBALS['TL_LANG']['tl_boxes4ward_article']['publish_legend']	= 'Publish';

