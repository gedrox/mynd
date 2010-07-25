<?php

require_once 'Zend/Registry.php';

/**
 * ControllerAbstraction
 */
class ControllerAbstraction extends \Zend_Controller_Action
{

	function getBaseUrl()
	{
		$baseUrl = $this->getFrontController()
				->getBaseUrl();
		return $baseUrl;
	}

	function init()
	{
		$smarty = $this->view->getSmarty();
		$smarty->assign('baseUrl', $this->getBaseUrl());
		$smarty->assign('headTitle', 'Mynd');
	}

	function redirect($url, $code = 302)
	{
		$url = rtrim('/' . ltrim($url, '/'), '/') . '/';
		$baseUrl = $this->getBaseUrl();
		$this->getResponse()->setRedirect($baseUrl . $url, $code);
	}

	/**
	 * @return \Smarty
	 */
	function getSmarty()
	{
		return $this->view->getSmarty();
	}
}