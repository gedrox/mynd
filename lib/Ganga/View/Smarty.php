<?php

namespace Ganga\View;

require 'Zend/View.php';
require_once 'Smarty/Smarty.class.php';

/**
 * Smarty Zend view plugin
 */
class Smarty extends \Zend_View
{
	/**
	 * @var \Smarty
	 */
	protected $smarty;

	/**
	 * @var boolean
	 */
	public $useSmarty = true;

	/**
	 * Run view
	 */
	protected function _run()
	{
		if ($this->useSmarty) {
			$smarty = $this->getSmarty();
			$smarty->assign($this->getVars());
			$smarty->assignByRef('THIS', $this);
			$smarty->display(func_get_arg(0));
		} else {
			$args = func_get_args();
			parent::_run($args[0]);
		}
	}

	/**
	 * Get Smarty object
	 * @return Smarty
	 */
	public function getSmarty()
	{
		if ( ! isset($this->smarty)) {
			$this->smarty = \Zend_Registry::get('Smarty');
			$this->smarty->clearAllAssign();
			$this->smarty->assign('session', \Zend_Registry::get('Session'));
		}
		return $this->smarty;
	}
}