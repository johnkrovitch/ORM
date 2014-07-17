<?php

namespace JohnKrovitch\ORMBundle\Database\Schema;

/**
 * Schema
 *
 * A database schema is just a list of columns and fields, with behaviors
 */
class Schema
{
    protected $tables = [];
    protected $behaviors = [];

    public function addTable(Table $table)
    {
        $this->tables[] = $table;
    }

    public function addBehavior(Behavior $behavior)
    {
        $this->behaviors[] = $behavior;
    }
} 