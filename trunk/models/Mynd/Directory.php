<?php

namespace Mynd;

/**
 * @method boolean canShow()
 * @method string getImageSrc(string $name)
 * @method string getCacheFolder()
 * @method string getExtension()
 * @method string getHash()
 * @method Entity\Item getItem()
 * @method integer getStatus()
 */
class Directory extends \DirectoryIterator
{
	function rewind()
	{
		parent::rewind();
		$current = parent::current();
		if ($current && ! $current->canShow()) {
			$this->next();
		}
	}

	function current()
	{
		$current = parent::current();
		return $current;
	}

	function next()
	{
		do {
			parent::next();
		} while ($this->valid() && ! parent::current()->canShow());
	}

	public function canShow()
	{
		if ($this->isDot()) {
			return false;
		}
		return $this->getFileInfo('Mynd\File')->canShow();
	}

	public static function normalizePath($path)
	{
		if (\DIRECTORY_SEPARATOR != '/') {
			$path = str_replace(\DIRECTORY_SEPARATOR, '/', $path);
		}
		return $path;
	}

	public function getPathname()
	{
		$path = parent::getPathname();
		return self::normalizePath($path);
	}
	
	public function getPath()
	{
		$path = parent::getPath();
		return self::normalizePath($path);
	}

	function __call($method, $arguments)
	{
		$file = $this->getFileInfo('Mynd\File');
		if ( ! (\method_exists($file, $method))) {
			throw new \Exception("Method '$method' not found");
		}
		return \call_user_func_array(array($file, $method), $arguments);
	}

	function getOrdered()
	{
		$list = new \ArrayIterator();
		foreach ($this as $item) {
			$list->append($item->getFileInfo('Mynd\File'));
		}
		$list->uasort(function(File $a, File $b) {
			if ($a->isDir() && ! $b->isDir()) {
				return -1;
			}
			if ( ! $a->isDir() && $b->isDir()) {
				return 1;
			}
			if ($a->isDir()) {
				return - \strcasecmp($a->getFilename(), $b->getFilename());
			} else {
				return \strcasecmp($a->getFilename(), $b->getFilename());
			}
		});
		return $list;
	}
}