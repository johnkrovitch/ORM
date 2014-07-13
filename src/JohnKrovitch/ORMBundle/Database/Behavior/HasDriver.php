<?php

namespace JohnKrovitch\ORMBundle\Database\Behavior;

use JohnKrovitch\ORMBundle\Database\Connection\Driver;

trait HasDriver
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * Return current driver
     *
     * @return Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set current driver
     *
     * @param Driver $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }
} 