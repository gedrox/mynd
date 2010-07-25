<?php

use Doctrine\Common\ClassLoader;

require_once 'Zend/Loader/Autoloader.php';
require_once 'Doctrine/Common/ClassLoader.php';

$classLoader = new ClassLoader('Doctrine');
$classLoader->register();
$classLoader = new ClassLoader('Symfony', 'Doctrine');
$classLoader->register();
$classLoader = new ClassLoader('Ganga');
$classLoader->register();
$classLoader = new ClassLoader('Mynd', APPLICATION_PATH . 'models');
$classLoader->register();

$autoloader = Zend_Loader_Autoloader::getInstance();