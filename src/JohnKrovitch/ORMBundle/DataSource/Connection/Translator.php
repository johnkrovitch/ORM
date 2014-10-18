<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection;

use JohnKrovitch\ORMBundle\DataSource\Connection\Result\RawResult;
use JohnKrovitch\ORMBundle\DataSource\Query;

interface Translator
{
    /**
     * Translate a query into data source native language
     *
     * @param Query $query
     * @return mixed
     */
    public function translate(Query $query);

    /**
     * Translate data source query results into a readable data for QueryResult
     *
     * @param RawResult $rawResult
     * @return mixed
     */
    public function reverseTranslate(RawResult $rawResult);
}