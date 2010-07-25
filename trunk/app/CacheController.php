<?php

require_once 'ControllerAbstraction.php';

class CacheController extends ControllerAbstraction
{
	static $sizes = array(
		'small',
		'large'
	);

	public function imgAction()
	{
		ini_set('memory_limit', '256M');

		$this->_helper->viewRenderer->setNoRender(true);
		$request = $this->getRequest();
		if ( ! ($request instanceof Zend_Controller_Request_Http)) {
			throw new \Exception('Not HTTP request');
		}

		$response = $this->getResponse();
		if ( ! ($response instanceof Zend_Controller_Response_Http)) {
			throw new \Exception('Not HTTP response');
		}

		$pathInfo = $request->getPathInfo();
		$baseLength = 3;
		$baseLength += strlen($request->getControllerName());
		$baseLength += strlen($request->getActionName());
		$pathInfo = substr($pathInfo, $baseLength);
		$pathInfo = urldecode($pathInfo);
		
		$pathArray = explode('/', $pathInfo);

		$size = array_pop($pathArray);
		list($size, $extension) = explode('.', $size);
		$hash = array_pop($pathArray);
		$file = array_pop($pathArray);
		$path = implode('/', $pathArray);

		if ( ! \in_array($size, self::$sizes)) {
			$response->setHttpResponseCode(404);
			return;
		}
		
		\Mynd\FileFinder::validateDir($path . '/' . $file);

		$fileFinder = new \Mynd\FileFinder($path . '/' . $file);
		$file = $fileFinder->getFile();
		if ( ! $file->canShow()) {
			$response->setHttpResponseCode(403);
			return;
		}

		$fileHash = $file->getHash();
		if ($fileHash != $hash) {
			$this->clearCache($file);
			\Reg::log()->debug('Hash does not match');
			$response->setHttpResponseCode(404);
			return;
		}

		if ($file->getExtension() != '.' . $extension) {
			\Reg::log()->debug('Extension does not match');
			$response->setHttpResponseCode(404);
			return;
		}

		$path = $file->getPathname();
		$im = imagecreatefromjpeg($path);
		list($width, $height) = getimagesize($path);
		$min = min($width, $height);

		$exif = exif_read_data($path);
		$ort = $exif['Orientation'];
		$angle = 0;
		switch ($ort) {
			case 6:
				$angle = -90;
				//imagerotate($im, -90, 0);
				//list($width, $height) = array($height, $width);
				break;
			case 8:
				$angle = 90;
				//imagerotate($im, 90, 0);
				//list($width, $height) = array($height, $width);
				break;
		}

		foreach (self::$sizes as $_size) {

			switch ($_size) {
				case 'small':
					$dstW = 100;
					$dstH = 100;
					$dst = imagecreatetruecolor($dstW, $dstH);
					if ($width > $height) {
						imagecopyresampled($dst, $im, 0, 0, ($width - $height) / 2, 0, $dstW, $dstH, $height, $height);
					} else {
						imagecopyresampled($dst, $im, 0, 0, 0, ($height - $width) / 2, $dstW, $dstH, $width, $width);
					}
					break;
				case 'large':
					$maxW = 1280;
					$maxH = 850;
					if ($angle != 0) {
						list($maxW, $maxH) = array($maxH, $maxW);
					}
					$coefW = $maxW / $width;
					$coefH = $maxH / $height;
					$coef = min($coefW, $coefH, 1);
					$dstW = $coef * $width;
					$dstH = $coef * $height;
					$dst = imagecreatetruecolor($dstW, $dstH);
					imagecopyresampled($dst, $im, 0, 0, 0, 0, $dstW, $dstH, $width, $height);
					break;
				default:
					\Reg::log()->debug('Unknown size');
					$response->setHttpResponseCode(404);
					return;
			}

			if ($angle != 0) {
				$dst = imagerotate($dst, $angle, 0);
			}

			$cacheFile = WEBROOT_PATH . $file->getImageSrc($_size);
			if ( ! \is_dir(dirname($cacheFile))) {
				mkdir(dirname($cacheFile), 0777, true);
			}

			if (headers_sent()) {
				throw new \Exception('Headers already sent...');
			}

			$ob = ob_get_clean();
			if ( ! empty($ob)) {
				\Reg::log()->error('Unexpected output: ' . $ob);
			}

			header('Content-type: image/jpeg');
			//imagejpeg($dst);
			imagejpeg($dst, $cacheFile);
		}

		$cacheFile = WEBROOT_PATH . $file->getImageSrc($size);
		echo file_get_contents($cacheFile);

		$this->clearCache($file);
		
	}

	function clearCache(Mynd\File $file)
	{
		// disable cache clearing
		return;

		$path = $file->getPath();
		$name = $file->getFilename();
		$hash = $file->getHash();
		$extension = $file->getExtension();
		if (empty($extension)) {
			throw new \Exception('Files with no extension are not allowed');
		}

		$cacheFolder = $file->getCacheFolder();
		$dir = new DirectoryIterator(WEBROOT_PATH . $cacheFolder);
		foreach ($dir as $hashDir) {
			if ($hashDir->isDot()) {
				continue;
			}
			if ($hashDir->getFilename() == $hash) {
				continue;
			}
			if (strlen($hashDir->getFilename()) != 32) {
				\Reg::log()->warn('Folder name expected to consist of 32 characters');
				continue;
			}
			if ( ! $hashDir->isDir()) {
				\Reg::log()->warn('Cache folder expected to contain folders only');
				continue;
			}
			foreach ($hashDir as $sizeFile) {
				if ( ! $sizeFile->isDot()) {
					continue;
				}
				$test = '/^(' . implode('|', self::$sizes) . ')' . addslashes($extension, '.') . '$/';
				if (preg_match($test, $sizeFile->getFilename())) {
					unlink($sizeFile->getPathname());
				} else {
					\Reg::log()->warn("Could not delete file {$sizeFile->getPathname()}");
				}
			}
			rmdir($hashDir->getPathname());
		}
		
	}
}