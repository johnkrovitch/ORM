<?php

namespace JohnKrovitch\ORMBundle\DataSource\Base;

use JohnKrovitch\ORMBundle\Behavior\Collection;
use JohnKrovitch\ORMBundle\DataSource\QueryResult;
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