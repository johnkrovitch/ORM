<?php

namespace App\Manager;

use App\Database\Connection\Database;
use App\Exception\Exception;

class DatabaseManager
{
    /**
     * @var array
     */
    private $ORMDatabaseConfiguration;

    /**
     * @var Database[]
     */
    private $databases = [];

    /**
     * @var DriverManager
     */
    private $driverManager;

    /**
     * DatabaseManager constructor.
     *
     * @param array         $ORMDatabaseConfiguration
     * @param DriverManager $driverManager
     */
    public function __construct(array $ORMDatabaseConfiguration, DriverManager $driverManager)
    {
        $this->ORMDatabaseConfiguration = $ORMDatabaseConfiguration;
        $this->driverManager = $driverManager;
    }

    public function load()
    {
        foreach ($this->ORMDatabaseConfiguration as $name => $configuration) {
            $database = new Database($name, $configuration['dsn'], $configuration['driver'], $configuration['schema']);
            $this->driverManager->load($database);
            $this->databases[$name] = $database;
        }
    }

    /**
     * @param $name
     *
     * @return Database
     *
     * @throws Exception
     */
    public function get($name): Database
    {
        if (!key_exists($name, $this->databases)) {
            throw new Exception('Trying to get an unknown database "'.$name.'". did you forget to call load() ?');
        }

        return $this->databases[$name];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->databases;
    }
}
