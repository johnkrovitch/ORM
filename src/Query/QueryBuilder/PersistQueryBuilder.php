<?php

namespace App\Query\QueryBuilder;

use App\Query\PersistQuery;

class PersistQueryBuilder
{
    protected $query;

    protected $wheres = [];

    protected $table;

    protected $columns = [];

    protected $values = [];

    public function __construct()
    {
        $this->query = new PersistQuery();
    }

    public function update(string $table, array $columns, array $values)
    {
        $this->query->setType(PersistQuery::QUERY_TYPE_UPDATE);
    }
}
