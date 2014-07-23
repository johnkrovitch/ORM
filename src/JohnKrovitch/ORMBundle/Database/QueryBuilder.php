<?php

namespace JohnKrovitch\ORMBundle\Database;

use JohnKrovitch\ORMBundle\Behavior\HasType;

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

    public function addParameter($name, $value)
    {
        $this->query->addParameter($name, $value);
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