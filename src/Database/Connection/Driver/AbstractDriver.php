<?php

namespace App\Database\Connection\Driver;

use App\Database\Connection\Connection;
use App\Database\Connection\Driver;
use App\Exception\Exception;

abstract class AbstractDriver implements Driver
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @return Connection
     *
     * @throws Exception
     */
    public function getConnection(): Connection
    {
        if (null === $this->connection) {
            throw new Exception('The connection is not set for the current driver');
        }

        return $this->connection;
    }
}
