<?php

namespace JohnKrovitch\ORMBundle\DataSource;

use JohnKrovitch\ORMBundle\Behavior\Parameters;
use JohnKrovitch\ORMBundle\Behavior\Type;

class Query
{
    use Type, Parameters;

    protected $translatedQuery;

    protected $isExecuted = false;

    /**
     * Additional queries executed after main query
     *
     * @var array
     */
    protected $queries = [];

    public function setTranslatedQuery($translatedQuery)
    {
        $this->translatedQuery = $translatedQuery;
    }

    public function getTranslatedQuery()
    {
        return $this->translatedQuery;
    }

    /**
     * Return true is the query was executed
     *
     * @return boolean
     */
    public function isExecuted()
    {
        return $this->isExecuted;
    }

    public function setExecuted($isExecuted)
    {
        $this->isExecuted = $isExecuted;
    }

    public function addQuery(Query $query)
    {
        $this->queries[] = $query;
    }

    public function getQueries()
    {
        return $this->queries;
    }

    public function hasQueries()
    {
        return filter_var(count($this->queries), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return string
     */
    public function toString()
    {
        die('query to string not implemented');
        //return '';
    }
} 