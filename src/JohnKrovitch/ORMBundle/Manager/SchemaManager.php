<?php

namespace JohnKrovitch\ORMBundle\Manager;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasContainer;
use JohnKrovitch\ORMBundle\Behavior\HasSource;
use JohnKrovitch\ORMBundle\Behavior\HasSourceManager;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Database;
use JohnKrovitch\ORMBundle\Database\Schema\Column;
use JohnKrovitch\ORMBundle\Database\Schema\Schema;
use JohnKrovitch\ORMBundle\Database\Schema\Table;

/**
 * SchemaLoader
 *
 * Transforms data from sources into orm Tables, then manipulates schema to create/update database
 */
class SchemaManager
{
    use HasContainer, HasSourceManager, HasSource;

    /**
     * Arrays of drivers by type to access to origin data sources
     *
     * @var array
     */
    protected $originDrivers = [];

    /**
     * Arrays of drivers by type to access to destination data sources
     *
     * @var array
     */
    protected $destinationDrivers = [];

    /**
     * Current schema
     *
     * @var Schema
     */
    protected $schema = [];

    protected $isLoaded = false;

    /**
     * Loading schema data into objects
     *
     * @throws \Exception
     */
    public function load()
    {
        if (!$this->drivers) {
            throw new Exception('No driver was passed to the schema loader');
        }
        $this->schema = new Schema();
        /** @var Driver $driver */
        foreach ($this->drivers as $drivers) {

            foreach ($drivers as $driver) {
                $data = $driver->read();
                $this->checkData($data);
                $this->loadData($data);
            }
        }
        return $this->schema;
    }

    /**
     * Synchronize schema with database
     *
     * @throws \Exception
     */
    public function synchronize()
    {
        if (!$this->isLoaded) {
            throw new Exception('Schema must be loaded before updated');
        }
    }

    public function setDrivers(array $originDrivers, array $destinationDrivers)
    {
        $this->originDrivers = $originDrivers;
        $this->destinationDrivers = $destinationDrivers;
    }

    /**
     * Load schema data from source into schema objects Table and Column
     *
     * @param $data
     */
    protected function loadData($data)
    {
        // init database
        $allowedColumnsTypes = Constants::getColumnsAllowedTypes();

        // read data, create table and load table into database schema
        foreach ($data['tables'] as $tableName => $tableData) {
            $table = new Table();
            $table->setName($tableName);

            foreach ($tableData as $columnName => $columnsData) {
                $column = new Column();
                $column->setName($columnName);

                if (array_key_exists('behaviors', $columnsData) and in_array($columnsData['type'], $allowedColumnsTypes)) {
                    $column->setType($columnsData['type']);
                }
                if (array_key_exists('behaviors', $columnsData)) {
                    foreach ($columnsData['behaviors'] as $behavior) {
                        $column->addBehavior($behavior);
                    }
                }
                $table->addColumn($column);
            }
            $this->schema->addTable($table);
        }
        $this->isLoaded = true;
    }

    /**
     * Check data integrity. After calling this method, no more checks are required
     *
     * @param $data
     * @throws \Exception
     */
    protected function checkData($data)
    {
        if (!$data or !is_array($data)) {
            throw new Exception('Trying to load empty or in valid data. expected: array, got: ' . var_dump($data, true));
        }
        if (!array_key_exists('tables', $data)) {
            throw new Exception('Expecting "tables" root node');
        }
        // TODO check data integrity
    }
} 