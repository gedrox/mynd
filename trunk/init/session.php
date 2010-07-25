<?php

$session = new Zend_Session_Namespace(PROJECT_NAME);
\Zend_Registry::set('Session', $session);