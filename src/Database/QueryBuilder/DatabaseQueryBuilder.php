<?php

namespace App\Database\QueryBuilder;

use App\Database\Query;

class DatabaseQueryBuilder
{
    /**
     * @var Query
     */
    protected $query;

    public function describe(): DatabaseQueryBuilder
    {
        $this->query = new Query();
        $this->query->setType(Query::QUERY_TYPE_DESCRIBE);

        return $this;
    }

    public function showTables()
    {
        $this->query = new Query();
        $this->query->setType(Query::QUERY_TYPE_SHOW);

        return $this;
    }

    /**
     * @return Query
     */
    public function getQuery(): Query
    {
        return $this->query;
    }
}
