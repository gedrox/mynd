<?php

require_once 'Smarty/Smarty.class.php';

$smarty = new Smarty();

$smarty->template_dir = array(APPLICATION_PATH . 'views' . DIRECTORY_SEPARATOR . 'scripts');
$smarty->compile_dir = TMP_PATH;
$smarty->plugins_dir = array(SMARTY_PLUGINS_DIR);
$smarty->cache_dir = TMP_PATH;
//$smarty->config_dir = '.' . DS . 'configs' . DS;
$smarty->debug_tpl = SMARTY_DIR . 'debug.tpl';

Zend_Registry::set('Smarty', $smarty);