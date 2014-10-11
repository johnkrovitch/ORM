<?php

namespace JohnKrovitch\ORMBundle\DataSource\Schema;

use JohnKrovitch\ORMBundle\Behavior\Behaviors;
use JohnKrovitch\ORMBundle\Behavior\Name;

class Table
{
    use Name, Behaviors;

    protected $columns = [];

    public function addColumn(Column $column)
    {
        $this->columns[] = $column;
    }

    public function getColumns()
    {
        return $this->columns;
    }
} 