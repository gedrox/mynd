<?php

namespace Mynd\Entity;

/**
 * Mynd\Entity\Item
 */
class Item
{
	const STATUS_NEW = 0;
	const STATUS_HIDDEN = 10;
	const STATUS_VISIBLE = 50;
	const STATUS_STARRED = 100;

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $path
     */
    private $path;

    /**
     * @var integer $status
     */
    private $status;

	public function __construct(\SplFileInfo $directoryIterator)
	{
		$this->setPath($directoryIterator->getPath());
		$this->setName($directoryIterator->getFilename());
		$this->setStatus(self::STATUS_NEW);
	}

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param text $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return text $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return integer $status
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @var text $name
     */
    private $name;

    /**
     * @param text $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return text $name
     */
    public function getName()
    {
        return $this->name;
    }

	public function showGuest()
	{
		return in_array($this->status, 
				array(
					self::STATUS_VISIBLE,
					self::STATUS_STARRED
				));
	}
}