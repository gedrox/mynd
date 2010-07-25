<?php

$bootstrap = dirname(__DIR__) . '/init/web.php';
if (is_file($bootstrap)) {
	require $bootstrap;
} else {
	die('Bootstrap file not found');
}