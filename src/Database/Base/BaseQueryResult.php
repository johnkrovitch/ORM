<?php

namespace App\Database\Base;

use App\Behavior\Collection;
use App\Database\Query;
use App\Database\QueryResult;

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
