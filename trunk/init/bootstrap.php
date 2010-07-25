<?php

// PHP version check
if (version_compare(phpversion(), '5.3', '<')) {
	die('At least PHP version 5.3.0 is required');
}

// Path constants
define('APPLICATION_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('LIB_PATH', APPLICATION_PATH . 'lib' . DIRECTORY_SEPARATOR);
define('CONF_PATH', APPLICATION_PATH . 'conf' . DIRECTORY_SEPARATOR);
define('LOG_PATH', APPLICATION_PATH . 'log' . DIRECTORY_SEPARATOR);
define('TMP_PATH', APPLICATION_PATH . 'tmp' . DIRECTORY_SEPARATOR);
define('CONTROLLER_PATH', APPLICATION_PATH . 'controllers' . DIRECTORY_SEPARATOR);
define('WEBROOT_PATH', APPLICATION_PATH . 'webroot' . DIRECTORY_SEPARATOR);

// add the library directory to include path
ini_set('include_path', get_include_path() . PATH_SEPARATOR . LIB_PATH);

// Define application environment
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Includes
require CONF_PATH . 'configuration.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'loader.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'registry.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'doctrine.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'log.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'session.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'smarty.php';