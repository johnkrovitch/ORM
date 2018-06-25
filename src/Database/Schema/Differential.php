<?php

namespace App\Database\Schema;

class Differential
{
    private $tables = [];

    private $columns = [];

    private $columnDiffs = [];

    public function addTable(Table $table)
    {
        $this->tables[$table->getName()] = $table;
    }

    public function addColumn($tableName, Column $column)
    {
        if (!key_exists($tableName, $this->columns)) {
            $this->columns[$tableName] = [];
        }
        $this->columns[$tableName][$column->getName()] = $column;
    }

    /**
     * @return array
     */
    public function getColumnDiffs(): array
    {
        return $this->columnDiffs;
    }

    public function addColumnDiff($columnName, ColumnDifferential $columnDiff): void
    {
        $this->columnDiffs[$columnName] = $columnDiff;
    }
}
