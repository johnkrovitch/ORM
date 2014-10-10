<?php

namespace JohnKrovitch\ORMBundle\DataSource\Schema;

use JohnKrovitch\ORMBundle\Behavior\HasBehaviors;
use JohnKrovitch\ORMBundle\Behavior\HasName;

class Table
{
    use HasName, HasBehaviors;

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