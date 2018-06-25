<?php

namespace App\Database\Connection;

use App\Database\Command;
use App\Database\Query;
use App\Database\QueryResult;
use App\Database\Result\Result;

interface Driver
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Connect source
     *
     * @param string $dsn
     */
    public function connect(string $dsn);

    /**
     * Read data from source
     *
     * @param Query $query
     *
     * @return Result
     */
    public function query(Query $query): Result;

    public function command(Command $command): Result;

    /**
     * @return Connection
     */
    public function getConnection(): Connection;
}
