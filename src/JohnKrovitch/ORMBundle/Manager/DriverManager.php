<?php

namespace JohnKrovitch\ORMBundle\Manager;

use Exception;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Connection\Driver\YmlDriver;

class DriverManager
{
    /**
     * Create instance drivers according to various sources
     *
     * @param array $sources
     * @throws Exception
     * @return array
     */
    public function createDriversFromSources(array $sources)
    {
        $drivers = [];

        /** @var Source $source */
        foreach ($sources as $source) {
            // we create a driver by source type
            if ($source->getType() == Constants::DATABASE_TYPE_YML) {
                $driver = new YmlDriver();
                $driver->setSource($source);
            } else {
                throw new Exception($source->getType() . ' driver is not implemented yet');
            }
            $drivers[$source->getType()][] = $driver;
        }
        return $drivers;
    }
}