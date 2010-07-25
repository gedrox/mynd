<?php

use Doctrine\ORM\EntityManager,
		Doctrine\ORM\Configuration,
		Doctrine\ORM\Tools\Export\ClassMetadataExporter,
		Doctrine\ORM\Mapping\Driver\YamlDriver;

// Config object
$config = new Configuration;

// Get cache configured
$cacheClass = null;
if (defined('CACHE_DRIVER')) {
	if (class_exists(CACHE_DRIVER)) {
		$cacheClass = CACHE_DRIVER;
	} else {
		die('Cache class "' . CACHE_DRIVER . '" not found');
	}
}
if (empty($cacheClass)) {
	$cacheClass = 'Doctrine\Common\Cache\ArrayCache';
}

$cache = new $cacheClass;
$config->setMetadataCacheImpl($cache);
$driverImpl = new YamlDriver(APPLICATION_PATH . 'database/yml/');
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir(APPLICATION_PATH . 'models/' . PROJECT_NAME . '/Proxy');
$config->setProxyNamespace(PROJECT_NAME . '\Proxy');

$connectionOptions = array(
    'driver' => 'pdo_mysql',
    'user' => DB_USER,
	'password' => DB_PASSWORD,
	'dbname' => DB_NAME,
	'port' => DB_PORT,
	'charset' => 'UTF8',
	'driverOptions' => array(
		'charset' => 'UTF8'
	)
);

$em = EntityManager::create($connectionOptions, $config);

$em->getConnection()->executeQuery('SET NAMES \'UTF8\'');

ClassMetadataExporter::registerExportDriver('ganga_yaml', 'Ganga\Doctrine\YamlExportDriver');

\Zend_Registry::set('EntityManager', $em);