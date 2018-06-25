<?php

namespace App\Database;

use Exception;

class QueryBuilder
{
    /**
     * Main query
     *
     * @var Query
     */
    protected $query;

    /**
     * Other queries. They will be executed after main query
     *
     * @var array
     */
    protected $followingQueries = [];

    /**
     * Show elements from data source
     *
     * @param $type
     * @return $this
     * @throws Exception
     */
    public function show($type)
    {
        $this->query = new Query();
        $this->query->setType(Constants::QUERY_TYPE_SHOW);
        $this->query->addParameter('type', $type);

        return $this;
    }

    /**
     * Create data source
     *
     * @param $type string creation type (DATABASE, TABLE...)
     * @param $value
     * @return $this
     */
    public function create($type, $value)
    {
        $this->query = new Query();
        $this->query->setType(Constants::QUERY_TYPE_CREATE);
        $this->query->addParameter('type', $type);
        $this->query->addParameter('value', $value);

        return $this;
    }

    /**
     * Add a parameter into collection
     *
     * @param $name
     * @param $value
     * @return $this
     * @throws Exception
     */
    public function addParameter($name, $value)
    {
        $this->query->addParameter($name, $value);

        return $this;
    }

    public function addQuery(Query $query)
    {
        throw new Exception('add query not implement yet');
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function toString()
    {
        return $this->query->toString();
    }
}
