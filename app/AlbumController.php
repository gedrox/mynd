<?php

require_once 'ControllerAbstraction.php';

class AlbumController extends ControllerAbstraction
{

	public function indexAction()
	{
		$request = $this->getRequest();
		if ( ! ($request instanceof \Zend_Controller_Request_Http)) {
			throw new \Exception('Expected Http request');
		}

		$dir = $request->getQuery('dir');
		$dir = trim($dir, '/');
		if ( ! empty($dir)) {
			$dir .= '/';
		}
		
		$fileFinder = new \Mynd\FileFinder($dir);
		$files = $fileFinder->getFiles();

		$smarty = $this->getSmarty();

		$files = $files->getOrdered();
		$smarty->assignByRef('files', $files);

		$smarty->assign('dir', $dir);
		if ($dir) {
			$smarty->assign('breadCrumbs', explode('/', trim($dir, '/')));
		}

	}

}

