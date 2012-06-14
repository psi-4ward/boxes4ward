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
		'onload_callback' 			  	=> array(array('tl_boxes4ward_article', 'checkPermission')),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index',
			)
		)
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
				'icon'					=> 'header.gif',
				'button_callback'     => array('tl_boxes4ward_article', 'editHeader'),
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
				'button_callback'     => array('tl_boxes4ward_article', 'toggleIcon')
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
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_boxes4ward_category.name',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['name'],
			'exclude'					=> true,
			'inputType'					=> 'text',
			'search'					=> true,
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'						=> "varchar(255) NOT NULL default ''"
		),
		'pages' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['pages'],
			'inputType'               => 'pageTree',
			'eval'                    => array("multiple"=>true, 'fieldType'=>'checkbox'),
			'sql'					  => 'blob NULL'
		),
		'module_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['module_id'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'filter'                  => true,
			'options_callback'        => array('tl_boxes4ward_article', 'getModules'),
			'eval'                    => array('helpwizard'=>true, 'tl_class'=>'w50'),
			'sql'					  => "int(10) unsigned NOT NULL default '0'"
		),
		'reversePages' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['reversePages'],
			'exclude'                 => true,
			'filter'				  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'inheritPages' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['inheritPages'],
			'exclude'                 => true,
			'filter'				  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50'),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'published' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['published'],
			'exclude'					=> true,
			'filter'					=> true,
			'inputType'					=> 'checkbox',
			'eval'						=> array('doNotCopy'=>true),
			'sql'					  => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['start'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'					  => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_boxes4ward_article']['stop'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'					  => "varchar(10) NOT NULL default ''"
		)
	)
);


class tl_boxes4ward_article extends Backend
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
		$objModuls = \ModuleModel::findBy('type','boxes4ward');

		while($objModuls->next())
		{
			$arrModuls[$objModuls->id] = $objModuls->name;
		}

		return $arrModuls;
	}


	/**
	 * Check permissions to edit table tl_news4ward_article
	 */
	public function checkPermission()
	{

		if ($this->User->isAdmin)
		{
			// allow admins
			return;
		}

		// find tl_news4archiv.id
		if(!Input::get('act') || in_array(Input::get('act'),array('create','select','editAll','overrideAll')))
		{
			$boxes4wardID = Input::get('id');
		}
		else
		{
			$objArticle = \Contao\ArticleModel::findByPk(\Contao\Input::get('id'));
			$boxes4wardID = $objArticle->pid;
		}

		if(is_array($this->User->boxes4ward) && count($this->User->boxes4ward) > 0 && in_array($boxes4wardID,$this->User->boxes4ward)) return;

		$this->log('Not enough permissions to '.Input::get('act').' boxes4ward category ID "'.$news4wardID.'"', 'tl_boxes4ward_article checkPermission', TL_ERROR);
		$this->redirect('contao/main.php?act=error');
	}


	/**
	 * Return the edit header icon
	 * @param $row
	 * @param $href
	 * @param $label
	 * @param $title
	 * @param $icon
	 * @param $attributes
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		if (!$this->User->isAdmin && count(preg_grep('/^tl_boxes4ward_article::/', $this->User->alexf)) < 1)
		{
			return '';
		}

		return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_boxes4ward_article::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');
		$this->checkPermission();

		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_boxes4ward_article::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish boxes4ward_article ID "'.$intId.'"', 'tl_boxes4ward_article toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_boxes4ward_article', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_boxes4ward_article']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_boxes4ward_article']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$objArticle = \Boxes4ward\Boxes4wardArticleModel::findByPk($intId);
		$objArticle->published = ($blnVisible ? '1' : '');
		$objArticle->save();

		$this->createNewVersion('tl_boxes4ward_article', $intId);
	}

}
