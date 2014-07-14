<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasDriver;
use JohnKrovitch\ORMBundle\Behavior\HasName;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Constants;

trait SourceBehavior
{
    use HasDriver, HasName;

    protected $login;

    protected $password;

    protected $host;

    protected $port;

    /**
     * Defines connection parameters
     *
     * @param $host
     * @param $name
     * @param null $login
     * @param null $password
     * @param null $port
     */
    public function setParameters($host, $name, $login = null, $password = null, $port = null)
    {
        $this->host = $host;
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->port = $port;
    }

    protected function checkParameters()
    {
        if (!$this->host) {
            throw new Exception('Invalid host name');
        }
        if (!$this->name) {
            $this->name = uniqid('orm.connection.');
        }
        if (!$this->port) {
            // set mysql default port
            if ($this->getDriver()->getType() == Constants::DRIVER_TYPE_PDO_MYSQL) {
                $this->port = '3306';
            }
        }
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