<?php

namespace Mynd;

class FileFinder
{
	protected $dir;

	protected $path;

	function __construct($path)
	{
		self::validateDir($path);

		if ( ! \defined('IMAGE_PATH')) {
			throw new \Exception('Image path not defined');
		}
		$path = \IMAGE_PATH . \DIRECTORY_SEPARATOR . $path;
		$this->dir = \is_dir($path);
		if ( ! $this->dir && ! \is_file($path)) {
			throw new \Exception('Such file/folder was not found');
		}
		$this->path = $path;
	}

	function getFiles()
	{
		if ( ! $this->dir) {
			throw new \Exception('The node is file');
		}
		$files = new Directory($this->path);
		return $files;
	}

	/**
	 * @return File
	 */
	function getFile()
	{
		if ($this->dir) {
			throw new \Exception('The node is directory');
		}
		return new File($this->path);
	}

	static function validateDir($dir)
	{
		if (\DIRECTORY_SEPARATOR != '/') {
			$dir = str_replace(\DIRECTORY_SEPARATOR, '/', $dir);
		}
		if (preg_match('!(^|/)\.{1,2}($|/)!', $dir)) {
			throw new \Exception('Such directory name is not allowed');
		}
	}
}