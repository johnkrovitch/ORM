<?php

namespace JohnKrovitch\ORMBundle\Database;

use JohnKrovitch\ORMBundle\Behavior\HasType;

class QueryBuilder
{
    /**
     * @var Query
     */
    protected $query;

    public function show()
    {
        $this->query = new Query();
        $this->query->setType(Constants::QUERY_TYPE_SHOW);

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