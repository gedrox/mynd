<?php

namespace Mynd\Entity;

/**
 * Mynd\Entity\Usr
 */
class Usr
{
	const PASSWORD_SALT = 'skjfb&^%$87654HV":';

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $login
     */
    private $login;

    /**
     * @var string $pssw
     */
    private $pssw;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * Get login
     *
     * @return string $login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set pssw
     *
     * @param string $pssw
     */
    public function setPssw($pssw)
    {
        $this->pssw = $this->hashPassword($psswd);
    }

    /**
     * Get pssw
     *
     * @return string $pssw
     */
    public function getPssw()
    {
        return $this->pssw;
    }

	public function checkPassword(&$password)
	{
		if ($password == '') {
			return false;
		}
		$hash = $this->hashPassword($password);
		$result = ($this->pssw == $hash);
		// unset the password for security
		$password = null;
		return $result;
	}

	public function hashPassword($password)
	{
		return md5($password . self::PASSWORD_SALT);
	}


}