<?php

$logger = new Zend_Log();

$logPath = LOG_PATH . PROJECT_NAME . '_' . date('Y-m-d') . '.log';
$dailyFile = new Zend_Log_Writer_Stream($logPath);
$dailyFileFilter = new Zend_Log_Filter_Priority(LOG_PRIORITY);
$dailyFile->addFilter($dailyFileFilter);

$fireBug = new Zend_Log_Writer_Firebug();
$fireBugFilter = new Ganga\Log\FilterIp('/^127|192|10\./');
$fireBug->addFilter($fireBugFilter);

$logger->addWriter($dailyFile);
$logger->addWriter($fireBug);

$logger->addPriority('error', (string)(Zend_Log::ERR + 0.5));
$logger->addPriority('fatal', (string)(Zend_Log::CRIT + 0.5));

Zend_Registry::set('Log', $logger);