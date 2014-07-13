<?php

namespace JohnKrovitch\ORMBundle\Database;

use Exception;
use JohnKrovitch\ORMBundle\Database\Connection\Connection;
use JohnKrovitch\ORMBundle\Database\Connection\Driver\MysqlDriver;

class Database
{
    /**
     * @var Connection
     */
    protected $connection;

    public function init($databaseDriver)
    {
        if ($databaseDriver == Constants::DRIVER_TYPE_PDO_MYSQL) {
            // mysql database driver
            $driver = new MysqlDriver();
            $this->connection->setDriver($driver);
        } else {
            throw new Exception('Invalid database driver type : ' . $databaseDriver);
        }
    }

    /**
     * @return \JohnKrovitch\ORMBundle\Database\Connection\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param \JohnKrovitch\ORMBundle\Database\Connection\Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}