<?php

namespace App\Database\Schema;

use App\Behavior\Behaviors;
use App\Behavior\Name;

class Table
{
    use Name, Behaviors;

    protected $columns = [];

    public function addColumn(Column $column)
    {
        $this->columns[$column->getName()] = $column;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getColumn($name)
    {
        return $this->columns[$name];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasColumn($name): bool
    {
        return key_exists($name, $this->columns);
    }
} 
