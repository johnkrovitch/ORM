<?php

namespace App\Manager;

use App\Database\Connection\Database;
use App\Database\Connection\Driver;

class DriverManager
{
    /**
     * @var Driver[]
     */
    private $drivers = [];

    /**
     * @param Database $database
     */
    public function load(Database $database)
    {
        foreach ($this->drivers as $driver) {
            if ($database->getDriverName() === $driver->getName()) {
                $driver->connect($database->getDsn());
                $database->setDriver($driver);
            }
        }
    }

    /**
     * @param Driver $driver
     */
    public function addDriver(Driver $driver)
    {
        $this->drivers[] = $driver;
    }
}
