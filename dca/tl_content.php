<?php if(!defined('TL_ROOT')) die('You cannot access this file directly!');

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


if(Input::get('do') == 'boxes4ward')
{
	// Dynamically add the permission check and parent table
	$GLOBALS['TL_DCA']['tl_content']['config']['ptable'] = 'tl_boxes4ward_article';
	$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('tl_content_boxes4ward', 'checkPermission');

	// we just use another tl_content header
	$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['headerFields'] = array('name');
	$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['header_callback'] = array('tl_content_boxes4ward','generateHeader');

}

/**
 * Class tl_content_boxes4ward
 * provides some some helper methods
 */
class tl_content_boxes4ward extends tl_content
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
	 * Add Modulname to headerFields
	 * @param string $add
	 * @param DataContainer $dc
	 * @return array
	 */
	public function generateHeader($add, $dc)
	{
		$objModule = $this->Database->prepare('SELECT tl_module.name FROM tl_module
												LEFT JOIN tl_boxes4ward_article ON (tl_module.id = tl_boxes4ward_article.module_id)
												WHERE tl_boxes4ward_article.id=?')->execute(CURRENT_ID);

		$add[$GLOBALS['TL_LANG']['tl_boxes4ward_article']['module_id'][0]] = $objModule->name;

		return $add;
	}

	/**
	 * Check permissions to edit table tl_content
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin)
		{
			return;
		}

		// Set the root IDs
		if (!is_array($this->User->boxes4ward) || empty($this->User->boxes4ward))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->boxes4ward;
		}

		// Check the current action
		switch (Input::get('act'))
		{
			case 'paste':
				// Allow
				break;

			case '': // empty
			case 'create':
			case 'select':
				// Check access to the news item
				if (!$this->checkAccessToElement(CURRENT_ID, $root, true))
				{
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				// Check access to the parent element if a content element is moved
				if ((Input::get('act') == 'cutAll' || Input::get('act') == 'copyAll') && !$this->checkAccessToElement(Input::get('pid'), $root, (Input::get('mode') == 2)))
				{
					$this->redirect('contao/main.php?act=error');
				}

				$objCes = $this->Database->prepare("SELECT id FROM tl_content WHERE ptable='tl_boxes4ward_article' AND pid=?")
										 ->execute(CURRENT_ID);

				$session = $this->Session->getData();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objCes->fetchEach('id'));
				$this->Session->setData($session);
				break;

			case 'cut':
			case 'copy':
				// Check access to the parent element if a content element is moved
				if (!$this->checkAccessToElement(Input::get('pid'), $root, (Input::get('mode') == 2)))
				{
					$this->redirect('contao/main.php?act=error');
				}
				// NO BREAK STATEMENT HERE

			default:
				// Check access to the content element
				if (!$this->checkAccessToElement(Input::get('id'), $root))
				{
					$this->redirect('contao/main.php?act=error');
				}
				break;
		}
	}


	/**
	 * Check access to a particular content element
	 * @param integer
	 * @param array
	 * @param boolean
	 * @return boolean
	 */
	protected function checkAccessToElement($id, $root, $blnIsPid=false)
	{
		if ($blnIsPid)
		{
			$objArchive = $this->Database->prepare("SELECT a.id, n.id AS nid FROM tl_boxes4ward_article n, tl_boxes4ward_category a WHERE n.id=? AND n.pid=a.id")
										 ->limit(1)
										 ->execute($id);
		}
		else
		{
			$objArchive = $this->Database->prepare("SELECT a.id, n.id AS nid FROM tl_content c, tl_boxes4ward_article n, tl_boxes4ward_category a WHERE c.id=? AND c.pid=n.id AND n.pid=a.id")
										 ->limit(1)
										 ->execute($id);
		}

		// Invalid ID
		if ($objArchive->numRows < 1)
		{
			$this->log('Invalid boxes4ward content element ID ' . $id, 'tl_content_boxes4ward checkAccessToElement()', TL_ERROR);
			return false;
		}

		// The news archive is not mounted
		if (!in_array($objArchive->id, $root))
		{
			$this->log('Not enough permissions to modify boxes4ward_article ID ' . $objArchive->nid . ' in boxes4ward archive ID ' . $objArchive->id, 'tl_content_boxes4ward checkAccessToElement()', TL_ERROR);
			return false;
		}

		return true;
	}

}