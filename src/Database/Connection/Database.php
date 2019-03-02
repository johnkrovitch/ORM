<?php

namespace App\Database\Connection;

use App\Exception\Exception;

class Database
{
    /**
     * @var string
     */
    private $driverName;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $dsn;

    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var string
     */
    private $schema;

    /**
     * Database constructor.
     *
     * @param string $name
     * @param string $dsn
     * @param string $driverName
     * @param string $schema
     */
    public function __construct(string $name, string $dsn, string $driverName, string $schema)
    {
        $this->driverName = $driverName;
        $this->name = $name;
        $this->dsn = $dsn;
        $this->schema = $schema;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @return string
     */
    public function getDriverName(): string
    {
        return $this->driverName;
    }

    /**
     * @return Driver
     */
    public function getDriver(): Driver
    {
        return $this->driver;
    }

    /**
     * @param Driver $driver
     *
     * @throws Exception
     */
    public function setDriver(Driver $driver): void
    {
        if (null !== $this->driver) {
            throw new Exception('The driver can only be set once');
        }
        $this->driver = $driver;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->driver->getConnection();
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }
}
