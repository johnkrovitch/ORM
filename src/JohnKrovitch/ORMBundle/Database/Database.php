<?php

namespace JohnKrovitch\ORMBundle\Database;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasSource;
use JohnKrovitch\ORMBundle\Database\Connection\Driver\MysqlDriver;

class Database
{
    use HasSource;

    protected $schema;

    public function connect()
    {
        $this->source->connect();
    }

    public function createDriver($databaseDriver)
    {
        if ($databaseDriver == Constants::DRIVER_TYPE_PDO_MYSQL) {
            // mysql database driver
            $driver = new MysqlDriver();
            $this->connection->setDriver($driver);
        } else {
            throw new Exception('Invalid database driver type : ' . $databaseDriver);
        }
    }
}