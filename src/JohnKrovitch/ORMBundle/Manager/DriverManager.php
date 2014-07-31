<?php

namespace JohnKrovitch\ORMBundle\Manager;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasContainer;
use JohnKrovitch\ORMBundle\DataSource\Connection\Source;
use JohnKrovitch\ORMBundle\DataSource\Constants;

class DriverManager
{
    use HasContainer;

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
            if ($source->getType() == Constants::DRIVER_TYPE_YML) {
                // yml type
                $driver = $this->getContainer()->get('orm.driver.yml');
            } else if ($source->getType() == Constants::DRIVER_TYPE_PDO_MYSQL) {
                // pdo mysql
                $driver = $this->getContainer()->get('orm.driver.mysql');
            } else {
                throw new Exception($source->getType() . ' driver is not implemented yet');
            }
            $driver->setSource($source);
            $drivers[$source->getType()][] = $driver;
        }
        return $drivers;
    }
}