<?php

namespace JohnKrovitch\ORMBundle\Utils;

use JohnKrovitch\ORMBundle\DataSource\Schema\Differential;
use JohnKrovitch\ORMBundle\DataSource\Schema\Schema;
use JohnKrovitch\ORMBundle\DataSource\Schema\Table;

class SchemaComparator
{
    /**
     * Return a differential between two schemas
     *
     * @param Schema $origin
     * @param Schema $destination
     * @return Differential
     */
    public function compare(Schema $origin, Schema $destination)
    {
        // schema differential object to return
        $differential = new Differential();
        // origin schema tables
        $originTables = $origin->getTables();
        // destination schema tables
        $destinationTables = $destination->getTables();

        // compare origin and destination tables names
        $differentialOrigin = array_diff(array_keys($originTables), array_keys($destinationTables));
        $differentialDestination = array_diff(array_keys($destinationTables), array_keys($originTables));

        foreach ($differentialOrigin as $tableName) {
            $differential->addOriginTable($originTables[$tableName]);
        }
        foreach ($differentialDestination as $tableName) {
            $differential->addDestinationTable($destinationTables[$tableName]);
        }
        // if two tables have the same name, we compare their columns
        $commonTables = array_intersect(array_keys($originTables), array_keys($destinationTables));

        foreach ($commonTables as $tableName) {
            $this->compareTables($differential, $originTables[$tableName], $destinationTables[$tableName]);
        }
        //var_dump($destinationTables);
        die('lol');
        return;
    }

    protected function compareTables(Differential $differential, Table $originTable, Table $destinationTable)
    {
        // finding unmatched columns in origin and destination
        $differentialOrigin = array_diff(array_keys($originTable->getColumns()), array_keys($destinationTable->getColumns()));
        $differentialDestination = array_diff(array_keys($destinationTable->getColumns()), array_keys($originTable->getColumns()));

        // adding to differential
        foreach ($differentialOrigin as $columnName) {
            $differential->addOriginColumn($originTable, $originTable->getColumn($columnName));
        }
        foreach ($differentialDestination as $columnName) {
            $differential->addDestinationColumn($destinationTable, $destinationTable->getColumn($columnName));
        }
        // if two columns have the same name, we compare them
        $commonColumns = array_intersect(array_keys($originTable->getColumns()), array_keys($destinationTable->getColumns()));

        die('TODO compare columns');
    }
} 