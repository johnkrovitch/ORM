<?php

namespace JohnKrovitch\ORMBundle\Manager;

use Exception;
use InvalidArgumentException;
use JohnKrovitch\ORMBundle\Behavior\HasContainer;
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
        $queryBuilder->show('TABLES');

        foreach ($this->originDrivers as $drivers) {
            /** @var Driver $driver */
            foreach ($drivers as $driver) {
                $data = $driver->query($queryBuilder->getQuery());
                $this->checkData($data);
                $this->loadSchema($data, $schema);
            }
        }
        $this->schema = $schema;

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
        if (!$this->destinationDrivers) {
            throw new Exception('Destination drivers for schema loader must be set before synchronizing');
        }
        $schema = new Schema();
        $queryBuilder = new QueryBuilder();
        $queryBuilder->show('TABLES');

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
        $differential = $this->compareSchema($this->schema, $schema);


        print_r($differential);


        die('sync in progress');
    }

    /**
     * Return a differential between two schemas
     *
     * @param Schema $origin
     * @param Schema $destination
     * @return Differential
     */
    public function compareSchema(Schema $origin, Schema $destination)
    {
        $unmatchedOrigin = [];
        $unmatchedDestination = [];
        $originTables = $origin->getTables();
        $destinationTables = $destination->getTables();
        // compare origin and destination tables
        $differentialOrigin = array_diff(array_keys($originTables), array_keys($destinationTables));
        $differentialDestination = array_diff(array_keys($destinationTables), array_keys($originTables));

        foreach ($differentialOrigin as $tableName) {
            $unmatchedOrigin[] = $originTables[$tableName];
        }
        foreach ($differentialDestination as $tableName) {
            $unmatchedDestination[] = $destinationTables[$tableName];
        }
        // if two tables have the same name, we compare their columns
        $commonTables = array_intersect(array_keys($originTables), array_keys($destinationTables));

        foreach ($commonTables as $tableName) {
            $unmatchedOrigin[] = $originTables[$tableName];
            $unmatchedDestination[] = $destinationTables[$tableName];
        }
        return new Differential($unmatchedOrigin, $unmatchedDestination);
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
     * @param $data
     * @param Schema $schema
     * @return Schema
     */
    protected function loadSchema($data, Schema $schema)
    {
        // init database
        $allowedColumnsTypes = Constants::getColumnsAllowedTypes();

        // TODO always have a query result
        if ($data instanceof QueryResult) {
            $tablesData = $data->getResults(Constants::FETCH_TYPE_ARRAY);
        } else {
            $tablesData = $data['tables'];
        }
        // read data, create table and load table into database schema
        foreach ($tablesData as $tableName => $tableData) {
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
            $schema->addTable($table);
        }
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
        } else if ($data instanceof QueryResult) {
            // data from query (generally database)
            $results = $data->getResults(Constants::FETCH_TYPE_ARRAY);

            if (!is_array($results)) {
                throw new InvalidArgumentException('Invalid data from query result for schema manager');
            }
        } else {
            throw new Exception('Trying to load empty or in valid data. expected: array, got: ' . "\n" . print_r($data, true));
        }
        // TODO check data integrity
    }
} 