<?php

namespace JohnKrovitch\ORMBundle\Database\Schema;

use Exception;
use JohnKrovitch\ORMBundle\Database\Behavior\HasContainer;
use JohnKrovitch\ORMBundle\Database\Connection\Connection;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Database;

class SchemaLoader
{
    use HasContainer;

    protected $drivers = [];

    protected $schema = [];

    public function load()
    {
        if (!$this->drivers) {
            throw new Exception('No driver was passed to the schema loader');
        }
        /** @var Driver $driver */
        foreach ($this->drivers as $drivers) {

            foreach ($drivers as $driver) {
                $data = $driver->read();
                $this->checkData($data);
                $this->loadData($data, $driver);
            }
        }
    }

    public function setDrivers(array $drivers)
    {
        $this->drivers = $drivers;
    }

    protected function checkData($data)
    {
        if (!$data or !is_array($data)) {
            throw new Exception('Trying to load empty or in valid data. expected: array, got: ' . var_dump($data, true));
        }
        if (!array_key_exists('tables', $data)) {
            throw new Exception('Expecting "tables" root node');
        }
    }

    protected function loadData($data)
    {
        // get parameters from container
        $host = $this->getContainer()->getParameter('database_host');
        $databaseDriver = $this->getContainer()->getParameter('database_driver');
        $name = $this->getContainer()->getParameter('database_name');
        $port = $this->getContainer()->getParameter('database_port');
        $login = $this->getContainer()->getParameter('database_user');
        $password = $this->getContainer()->getParameter('database_password');

        // init database
        /** @var Connection $connection */
        $connection = $this->getContainer()->get('orm.database.connection');
        $connection->setParameters($host, $name, $login, $password, $port);

        /** @var Database $database */
        $database = $this->getContainer()->get('orm.database');
        $database->setConnection($connection);
        $database->init($databaseDriver);

        // read data, create table and load table into database schema
        foreach ($data['tables'] as $tableName => $tableData) {
            $table = new Table();
            $table->setName($tableName);

            foreach ($tableData as $columnName => $columnsData) {
                $column = new Column();
                $column->setName($columnName);

                if (array_key_exists('behaviors', $columnsData)) {
                    $column->setType($columnsData['type']);
                }
                if (array_key_exists('behaviors', $columnsData)) {
                    foreach ($columnsData['behaviors'] as $behavior) {
                        $column->addBehavior($behavior);
                    }
                }
                $table->addColumn($column);
            }
            $this->schema[] = $table;
        }
    }
} 