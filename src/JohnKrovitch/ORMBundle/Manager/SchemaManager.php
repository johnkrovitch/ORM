<?php

namespace JohnKrovitch\ORMBundle\Manager;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\EventDispatcher;
use JohnKrovitch\ORMBundle\Behavior\HasSchemaComparator;
use JohnKrovitch\ORMBundle\Behavior\HasSource;
use JohnKrovitch\ORMBundle\Behavior\HasSourceManager;
use JohnKrovitch\ORMBundle\DataSource\Connection\Driver;
use JohnKrovitch\ORMBundle\DataSource\Constants;
use JohnKrovitch\ORMBundle\DataSource\QueryBuilder;
use JohnKrovitch\ORMBundle\DataSource\QueryResult;
use JohnKrovitch\ORMBundle\DataSource\Schema\Column;
use JohnKrovitch\ORMBundle\DataSource\Schema\Differential;
use JohnKrovitch\ORMBundle\DataSource\Schema\Schema;
use JohnKrovitch\ORMBundle\DataSource\Schema\Table;
use JohnKrovitch\ORMBundle\Event\Event;
use JohnKrovitch\ORMBundle\Event\SchemaEvent;

/**
 * SchemaLoader
 *
 * Transforms data from sources into orm Tables, then manipulates schema to create/update database
 */
class SchemaManager
{
    use HasSourceManager, HasSchemaComparator, HasSource, EventDispatcher;

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

    /**
     * If true, schema has already been loaded
     *
     * @var bool
     */
    protected $isLoaded = false;

    /**
     * Loading schema data into objects
     *
     * @return Schema
     * @throws Exception
     */
    public function load()
    {
        if (!$this->originDrivers) {
            throw new Exception('No origin driver was passed to the schema loader');
        }
        $schema = new Schema();
        $queryBuilder = new QueryBuilder();
        $queryBuilder->describe();

        foreach ($this->originDrivers as $drivers) {
            /** @var Driver $driver */
            foreach ($drivers as $driver) {
                $queryResult = $driver->query($queryBuilder->getQuery());
                $this->checkData($queryResult);
                $this->loadSchema($queryResult, $schema);
            }
        }
        $this->schema = $schema;

        return $this->schema;
    }

    /**
     * Synchronize schema with database
     *
     * @throws Exception
     */
    public function synchronize()
    {
        if (!$this->isLoaded) {
            throw new Exception('Schema must be loaded before updated');
        }
        if (!$this->destinationDrivers) {
            throw new Exception('Destination drivers for schema loader must be set before synchronizing');
        }
        $schema = new Schema();
        $queryBuilder = new QueryBuilder();
        $queryBuilder->describe();

        // load schema from database destination
        foreach ($this->destinationDrivers as $drivers) {
            /** @var Driver $driver */
            foreach ($drivers as $driver) {
                $queryResult = $driver->query($queryBuilder->getQuery());
                $this->checkData($queryResult);
                $this->loadSchema($queryResult, $schema);
            }
        }
        // compare origin schema and destination schema
        /** @var Differential $differential */
        $differential = $this->getSchemaComparator()->compare($this->schema, $schema);
        // update destination schema with source data
        $originTables = $differential->getOriginUnMatchedTables();

        foreach ($originTables as $table) {
            foreach ($this->destinationDrivers as $drivers) {
                foreach ($drivers as $driver) {
                    $queryBuilder = new QueryBuilder();
                    $queryBuilder->create('TABLE', $table);
                    $driver->query($queryBuilder->getQuery());
                }
            }
        }
        // TODO handle column deletion

        // trigger synchronization successful event
        $this->getEventDispatcher()->dispatch(Event::ORM_SCHEMA_SYNCHRONIZED, new SchemaEvent($this->schema));
    }

    /**
     * Define driver for data sources origin and data source destination
     *
     * @param array $originDrivers
     * @param array $destinationDrivers
     */
    public function setDrivers(array $originDrivers, array $destinationDrivers)
    {
        $this->originDrivers = $originDrivers;
        $this->destinationDrivers = $destinationDrivers;
    }

    /**
     * Load schema data from source into schema objects Table and Column
     *
     * @param $queryResult
     * @param Schema $schema
     * @throws Exception
     * @return Schema
     */
    protected function loadSchema(QueryResult $queryResult, Schema $schema)
    {
        // init database
        $allowedColumnsTypes = Constants::getColumnsAllowedTypes();
        $tablesData = $queryResult->getResults(Constants::FETCH_TYPE_ARRAY);

        // read data, create table and load table into database schema
        foreach ($tablesData as $tableName => $tableData) {
            $table = new Table();
            $table->setName($tableName);

            foreach ($tableData as $columnName => $columnsData) {
                // class behaviors
                if ($columnName == 'behaviors') {
                    foreach ($columnsData as $behavior) {
                        $table->addBehavior($behavior);
                    }
                    // behaviors is not a "real" column, we skip the rest of the process
                    continue;
                }
                // guess id type if not exist
                if ($columnName == 'id' and !array_key_exists('type', $columnsData)) {
                    $columnsData['type'] = 'id';
                }
                // type must exists
                if (!array_key_exists('type', $columnsData)) {
                    throw new Exception('Column type is null for column: "' . $columnName . '"');
                }
                // set type if allowed{}
                if (!in_array($columnsData['type'], $allowedColumnsTypes)) {
                    throw new Exception('Invalid column type: "' . $columnsData['type'] . '", name : ' . $columnName);
                }
                // creating new column
                $column = new Column();
                $column->setName($columnName);
                $column->setType($columnsData['type']);

                // column behavior (unique, timestampable...)
                if (array_key_exists('behaviors', $columnsData)) {
                    foreach ($columnsData['behaviors'] as $behavior) {
                        $column->addBehavior($behavior);
                    }
                }
                // if column is nullable
                if (array_key_exists('nullable', $columnsData) and $columnsData['nullable'] === false) {
                    $column->setNullable(false);
                }
                $table->addColumn($column);
            }
            $schema->addTable($table);
        }
        $this->getEventDispatcher(Event::ORM_SCHEMA_LOAD, new SchemaEvent($schema));
        $this->isLoaded = true;

        return $schema;
    }

    /**
     * Check data integrity before loading schema. Ensures that data are valid before the schema is loaded.
     * After calling this method, no more checks are required
     *
     * @param $data
     * @throws \Exception
     */
    protected function checkData($data)
    {
        // TODO always have query result
        if (is_array($data)) {
            // array data (generally data from files)
            if (is_array($data) and !array_key_exists('tables', $data)) {
                throw new Exception('Expecting "tables" root node, got ' . "\n" . print_r($data, true));
            }
        } else {
            //throw new Exception('Trying to load empty or in valid data. expected: array, got: ' . "\n" . print_r($data, true));
        }
        // TODO check data integrity
    }
} 