<?php

require 'bootstrap.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    CONF_PATH . '/application.ini'
);

$smartyView = new Ganga\View\Smarty();
$smartyViewParams = array(
	'viewSuffix' => 'tpl',
);
$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($smartyView, $smartyViewParams);
Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

$application->bootstrap()->run();