<?php

namespace JohnKrovitch\ORMBundle\Database;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\Collection;
use PDOStatement;

abstract class QueryResult implements \Countable, \IteratorAggregate, \ArrayAccess
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

    /**
     * Return hydrate result from pdo statement
     *
     * @param $hydrationMode
     * @return array
     * @throws \Exception
     */
    public abstract function getResults($hydrationMode);

    /**
     * Return affected rows count
     *
     * @return int
     */
    public abstract function getCount();
}