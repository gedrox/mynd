<?php

namespace Ganga\Log;

/**
 * Log filter, filters by IP address regular expression
 */
class FilterIp extends \Zend_Log_Filter_Abstract
{

	/**
	 * @var string
	 */
	protected $ipPattern;

	public function __construct($ipPattern)
	{
		$this->ipPattern = $ipPattern;
	}

	/**
	 * @param array $config
	 * @return FilterIp
	 */
	static public function factory($config)
	{
		$filter = new self();
		$filter->setPattern($config['ipPattern']);
		return $filter;
	}

	/**
	 * @param string $pattern
	 */
	public function setPattern($pattern)
	{
		$this->ipPattern = $pattern;
	}

	/**
     * @param array $event
     * @return boolean
     */
	public function accept($event)
	{
		if ( ! isset($_SERVER['REMOTE_ADDR'])) {
			return false;
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		if (\preg_match($this->ipPattern, $ip)) {
			return true;
		}
		return false;
	}
}