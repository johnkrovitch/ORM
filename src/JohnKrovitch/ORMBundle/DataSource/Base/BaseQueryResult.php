<?php

namespace JohnKrovitch\ORMBundle\DataSource\Base;

use JohnKrovitch\ORMBundle\Behavior\Collection;
use JohnKrovitch\ORMBundle\DataSource\Query;
use JohnKrovitch\ORMBundle\DataSource\QueryResult;

abstract class BaseQueryResult implements QueryResult
{
    use Collection;

    /**
     * @var Query
     */
    protected $query;

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param Query $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }
}