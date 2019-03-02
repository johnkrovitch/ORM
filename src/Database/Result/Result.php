<?php

namespace App\Database\Result;

class Result
{
    /**
     * @var \PDOStatement
     */
    private $statement;

    /**
     * Result constructor.
     *
     * @param \PDOStatement $statement
     */
    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }
}
