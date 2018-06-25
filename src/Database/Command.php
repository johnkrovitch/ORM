<?php

namespace App\Database;

class Command
{
    protected $createDatabases = [];

    public function addCreateDatabase(string $name, array $options)
    {
        $this->createDatabases[$name] = $options;
    }

    public function removeCreateDatabase(string $name, array $options)
    {
        $this->createDatabases[$name] = $options;
    }

    /**
     * @return array
     */
    public function getCreateDatabases(): array
    {
        return $this->createDatabases;
    }
}
