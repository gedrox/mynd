<?php

namespace Ganga\Registry;

/**
 * Description of Registry
 */
class Registry extends \Zend_Registry
{
	/**
	 * @return \Zend_Log
	 */
	static public function log()
	{
		return self::get('Log');
	}
	/**
	 * @return \Smarty
	 */
	static public function smarty()
	{
		return self::get('Smarty');
	}
	/**
	 * @return \Zend_Session
	 */
	static public function session()
	{
		return self::get('Session');
	}
	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	static public function entityManager()
	{
		return self::get('EntityManager');
	}
}