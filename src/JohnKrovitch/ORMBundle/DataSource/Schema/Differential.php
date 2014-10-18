<?php

namespace JohnKrovitch\ORMBundle\DataSource\Schema;

class Differential
{
    protected $origin = [];

    protected $destination = [];

    public function addOriginColumn(Table $table, Column $column)
    {
        $this->origin['column'][] = [
            'table' => $table,
            'column' => $column
        ];
    }

    public function addOriginTable(Table $table)
    {
        $this->origin['table'][] = [
            'table' => $table
        ];
    }

    public function addDestinationColumn(Table $table, Column $column)
    {
        $this->destination['column'][] = [
            'table' => $table,
            'column' => $column
        ];
    }

    public function addDestinationTable(Table $table)
    {
        $this->destination['table'][] = [
            'table' => $table
        ];
    }
}