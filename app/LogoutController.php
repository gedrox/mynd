<?php

require_once 'ControllerAbstraction.php';

class LogoutController extends ControllerAbstraction
{

	public function indexAction()
	{
		$session = \Zend_Registry::get('Session');
		$session->loggedIn = false;
		$session->user = null;
		$this->redirect('/');
	}

}

