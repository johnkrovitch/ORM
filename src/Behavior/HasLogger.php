<?php

namespace App\Behavior;

use App\Database\Connection\Driver;
use Monolog\Logger;

trait HasLogger
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Return current logger
     *
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Set current logger
     *
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }
} 
