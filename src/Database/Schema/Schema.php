<?php

namespace App\Database\Schema;

use App\Exception\Exception;

/**
 * Schema.
 *
 * A database schema is just a list of columns and fields, with behaviors
 */
class Schema
{
    protected $tables = [];
    protected $behaviors = [];

    public function addTable(Table $table)
    {
        $this->tables[$table->getName()] = $table;
    }

    public function addBehavior(Behavior $behavior)
    {
        $this->behaviors[$behavior->getName()] = $behavior;
    }

    public function hasTable($name): bool
    {
        return key_exists($name, $this->tables);
    }

    /**
     * @param $name
     *
     * @return Table
     *
     * @throws Exception
     */
    public function getTable($name): Table
    {
        if (!$this->hasTable($name)) {
            throw new Exception('Table "'.$name.'" does not exists');
        }

        return $this->tables[$name];
    }

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return $this->tables;
    }
}
