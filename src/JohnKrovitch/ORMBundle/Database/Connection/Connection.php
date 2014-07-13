<?php

namespace JohnKrovitch\ORMBundle\Database\Connection;

use JohnKrovitch\ORMBundle\Database\Behavior\HasDriver;

class Connection
{
    use HasDriver;

    protected $name;

    protected $login;

    protected $password;

    protected $host;

    protected $port;

    public function setParameters($host, $name, $login = null, $password = null, $port = null)
    {
        $this->host = $host;
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }
}