<?php

require_once 'ControllerAbstraction.php';

class LoginController extends ControllerAbstraction
{

	public function indexAction()
	{
		
	}

	public function submitAction()
	{
		$request = $this->getRequest();
		if ( ! ($request instanceof Zend_Controller_Request_Http)) {
			throw new \Exception('Not http request');
		}
		if ( ! $request->isPost()) {
			$this->redirect('/login/');
			return;
		}
		/* @var $em Doctrine\ORM\EntityManager */
		$em = \Zend_Registry::get('EntityManager');
		$usrRep = $em->getRepository('Mynd\Entity\Usr');
		
		// bring to lowercase
		$login = $request->getPost('login');
		$login = mb_strtolower($login);

		$psswd = $request->getPost('password');
		
		if ($login == '' || $psswd == '') {
			$this->getSmarty()->assign('error', 1);
			$this->render('index');
			return;
		}
		/* @var $usr Mynd\Entity\Usr */
		$usr = $usrRep->findOneByLogin($login);
		if (empty($usr)) {
			$this->getSmarty()->assign('error', 2);
			$this->render('index');
			return;
		}
		if ( ! $usr->checkPassword($psswd)) {
			$this->getSmarty()->assign('error', 3);
			$this->render('index');
			return;
		}

		$session = \Zend_Registry::get('Session');
		$session->loggedIn = true;
		$session->user = $login;
		
		$this->redirect('/');
	}

}

