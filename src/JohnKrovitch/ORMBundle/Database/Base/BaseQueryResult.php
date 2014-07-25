<?php

namespace JohnKrovitch\ORMBundle\Database\Base;

use JohnKrovitch\ORMBundle\Behavior\Collection;
use JohnKrovitch\ORMBundle\Database\QueryResult;
use PDOStatement;

abstract class BaseQueryResult implements QueryResult
{
    use Collection;

    /**
     * @var PDOStatement
     */
    protected $statement;

    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
    }
}