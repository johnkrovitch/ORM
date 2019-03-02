<?php

namespace App\Manager;

use App\Configuration\ColumnConfiguration;
use App\Database\Behavior\PrimaryKey;
use App\Database\Connection\Database;
use App\Database\QueryBuilder\DatabaseQueryBuilder;
use App\Database\Result\Result;
use App\Database\Connection\Driver;
use App\Database\Constants;
use App\Database\QueryResult;
use App\Database\Schema\Column;
use App\Database\Schema\Differential;
use App\Database\Schema\Schema;
use App\Database\Schema\Table;
use App\Event\Event;
use App\Event\SchemaEvent;
use App\Exception\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Yaml;

/**
 * SchemaLoader.
 *
 * Transforms data from sources into orm Tables, then manipulates schema to create/update database
 */
class SchemaManager
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var string
     */
    private $kernelProjectDirectory;

    /**
     * SchemaManager constructor.
     *
     * @param string                   $kernelProjectDirectory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(string $kernelProjectDirectory, EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->kernelProjectDirectory = $kernelProjectDirectory;
    }

    public function load(Database $database)
    {
        $schema = new Schema();
        $queryBuilder = new DatabaseQueryBuilder();
        $queryBuilder->showTables();

        $result = $database->getDriver()->query($queryBuilder->getQuery());
        //$this->hydrate($result, $schema);

        $yamlSchemaPath = $this->kernelProjectDirectory.'/config/'.$database->getSchema();

        // TODO improve file checking
        $yaml = Yaml::parse(file_get_contents($yamlSchemaPath));
        $yamlSchema = new Schema();
        $this->loadYamlSchema($yamlSchema, $yaml);

        dump($yamlSchema);

        return $schema;
    }

    public function compare(Schema $origin, Schema $destination)
    {
        $diff = new Differential();

        foreach ($origin->getTables() as $originTable) {
            $tableExists = false;

            foreach ($destination->getTables() as $destinationTable) {
                // TODO compare collation too
                if ($destinationTable->getName() === $originTable->getName()) {
                    $tableExists = true;
                }
            }

            if (!$destination->hasTable($originTable->getName())) {
                $diff->addTable($originTable);
            } else {
                $destinationTable = $destination->getTable($originTable->getName());

                foreach ($originTable->getColumns() as $originColumn) {
                    if (!$destinationTable->hasColumn($originColumn->getName())) {
                        $diff->addColumn($originTable->getName(), $originColumn);
                    } else {
                        $destinationColumn = $destinationTable->getColumn($originColumn->getName());
                        $columnDiff = $this->compareColumn($originColumn, $destinationColumn);

                        $diff->addColumnDiffs($originColumn->getName(), $columnDiff);
                    }
                }
            }
        }
    }

    /**
     * @param Schema $schema
     * @param array  $yaml
     *
     * @throws Exception
     */
    private function loadYamlSchema(Schema $schema, array $yaml)
    {
        foreach ($yaml['entities'] as $class => $configuration) {
            if (!class_exists($class)) {
                throw new Exception('Class "'.$class.'" not found');
            }
            $table = new Table();
            $table->setName($configuration['table']);

            foreach ($configuration['fields'] as $fieldName => $fieldConfiguration) {
                $resolver = new OptionsResolver();
                $configuration = new ColumnConfiguration();
                $configuration->configureOptions($resolver);
                $fieldConfiguration = $resolver->resolve($fieldConfiguration);
                $behaviors = $this->convertOptionsToBehavior($fieldName, $fieldConfiguration['options']);

                $column = new Column(
                    $fieldName,
                    $fieldConfiguration['type'],
                    $fieldConfiguration['options'],
                    $behaviors
                );

                $table->addColumn($column);
            }
            $schema->addTable($table);
        }
    }

    private function compareColumn(Column $origin, Column $destination)
    {
    }

    protected function convertOptionsToBehavior($name, array $options): array
    {
        $behaviors = [];

        if (true === $options['primary_key']) {
            $behavior = new PrimaryKey([
                $name,
            ]);
            $behaviors[] = $behavior;
        }

        return $behaviors;
    }

    /**
     * Load schema data from source into schema objects Table and Column.
     *
     * @param Result $queryResult
     * @param Schema $schema
     *
     * @throws Exception
     *
     * @return Schema
     */
    protected function hydrate(Result $queryResult, Schema $schema)
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
                if ('behaviors' == $columnName) {
                    foreach ($columnsData as $behavior) {
                        $table->addBehavior($behavior);
                    }
                    // behaviors is not a "real" column, we skip the rest of the process
                    continue;
                }
                // guess id type if not exist
                if ('id' == $columnName and !array_key_exists('type', $columnsData)) {
                    $columnsData['type'] = 'id';
                }
                // type must exists
                if (!array_key_exists('type', $columnsData)) {
                    throw new Exception('Column type is null for column: "'.$columnName.'"');
                }
                // set type if allowed{}
                if (!in_array($columnsData['type'], $allowedColumnsTypes)) {
                    throw new Exception('Invalid column type: "'.$columnsData['type'].'", name : '.$columnName);
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
                if (array_key_exists('nullable', $columnsData) and false === $columnsData['nullable']) {
                    $column->setNullable(false);
                }
                $table->addColumn($column);
            }
            $schema->addTable($table);
        }
        $this->eventDispatcher->dispatch(Event::ORM_SCHEMA_LOAD, new SchemaEvent($schema));
        $this->isLoaded = true;

        return $schema;
    }

    /**
     * Synchronize schema with database.
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
     * Check data integrity before loading schema. Ensures that data are valid before the schema is loaded.
     * After calling this method, no more checks are required.
     *
     * @param $data
     *
     * @throws \Exception
     */
    protected function checkData($data)
    {
        // TODO always have query result
        if (is_array($data)) {
            // array data (generally data from files)
            if (is_array($data) and !array_key_exists('tables', $data)) {
                throw new Exception('Expecting "tables" root node, got '."\n".print_r($data, true));
            }
        } else {
            //throw new Exception('Trying to load empty or in valid data. expected: array, got: ' . "\n" . print_r($data, true));
        }
        // TODO check data integrity
    }
}
