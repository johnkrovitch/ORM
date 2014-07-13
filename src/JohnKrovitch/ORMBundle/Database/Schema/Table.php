<?php

namespace JohnKrovitch\ORMBundle\Database\Schema;

use JohnKrovitch\ORMBundle\Database\Behavior\HasName;

class Table
{
    use HasName;

    protected $columns = [];

    public function addColumn(Column $column)
    {
        $this->columns[] = $column;
    }
} 