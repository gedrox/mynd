<?php

namespace Mynd;

/**
 * File
 */
class File extends \SplFileInfo
{
	static $fileStatus = array();

	public function canShow()
	{
		$filename = $this->getPathname();
		if ( ! $this->isDir()) {
			$imageType = \exif_imagetype($filename);
			if ($imageType === false) {
				return false;
			}
			if ($imageType != IMAGETYPE_JPEG) {
				return false;
			}
		}

		$session = \Reg::session();
		// filter out hidden if not logged in
		if ( ! $session->loggedIn) {
			$item = $this->getItem();
			if ( ! $item->showGuest()) {
				return false;
			}
		}
		return true;
	}

	function getImageSrc($name)
	{
		if ($this->isDir()) {
			//TODO: fetch preview
			return null;
		} else {
			$src = $this->getCacheFolder();
			$src .= $this->getHash() . '/';
			$src .= $name . $this->getExtension();
			return $src;
		}
	}

	function getCacheFolder()
	{
		$path = $this->getPath();
		$filename = $this->getFilename();
		$extension = \strrchr($filename, '.');
		$path = substr($path, strlen(\IMAGE_PATH));
		$path = trim($path, '/');
		$src = '/cache/img/' . ($path ? $path . '/' : '');
		$src .= $filename . '/';
		return $src;
	}

	function getExtension()
	{
		$filename = $this->getFilename();
		$extension = \strrchr($filename, '.');
		return $extension;
	}

	function getHash()
	{
		return md5($this->getMTime() . $this->getCTime() . $this->getStatus());
	}

	public function getItem()
	{
		$path = $this->getPath();
		$name = $this->getFilename();
		$items = $this->getFolderItems($path);
		if (isset($items[$name])) {
			return $items[$name];
		} else {
			$item = new Entity\Item($this);
			$em = \Reg::entityManager();
			$em->persist($item);
			return $item;
		}
	}

	protected function getFolderItems($folder)
	{
		if ( ! isset(self::$fileStatus[$folder])) {
			self::$fileStatus[$folder] = array();
			$em = \Reg::entityManager();
			$itemRep = $em->getRepository('Mynd\Entity\Item');
			$items = $itemRep->findByPath($folder);
			/* @var $item Entity\Item */
			foreach ($items as $item) {
				self::$fileStatus[$folder][$item->getName()] = $items;
			}
		}
		return self::$fileStatus[$folder];
	}

	function getStatus()
	{
		return $this->getItem()->getStatus();
	}

	public function getPathname()
	{
		$path = parent::getPathname();
		return Directory::normalizePath($path);
	}

	public function getPath()
	{
		$path = parent::getPath();
		return Directory::normalizePath($path);
	}
}