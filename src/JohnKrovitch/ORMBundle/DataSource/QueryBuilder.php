<?php

namespace JohnKrovitch\ORMBundle\DataSource;

class QueryBuilder
{
    /**
     * @var Query
     */
    protected $query;

    public function show($type)
    {
        $this->query = new Query();
        $this->query->setType(Constants::QUERY_TYPE_SHOW);
        $this->query->addParameter('type', $type);

        return $this;
    }

    /**
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

    public function addParameter($name, $value)
    {
        $this->query->addParameter($name, $value);

        return $this;
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