<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Translator;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasLogger;
use JohnKrovitch\ORMBundle\Behavior\HasSanitizer;
use JohnKrovitch\ORMBundle\DataSource\Connection\Translator;
use JohnKrovitch\ORMBundle\DataSource\Constants;
use JohnKrovitch\ORMBundle\DataSource\Query;

/***
 * MysqlTranslator
 *
 * Translate Query object into MySql string
 */
class MysqlTranslator implements Translator
{
    use HasSanitizer;

    /**
     * Translate $query into mysql sanitized query string
     *
     * @param Query $query
     * @return mixed
     * @throws Exception
     */
    public function translate(Query $query)
    {
        if ($query->getType() == Constants::QUERY_TYPE_SHOW) {
            $translatedQuery = $this->translateShow($query);
        } else if ($query->getType() == Constants::QUERY_TYPE_USE) {
            $translatedQuery = $this->translateUse($query);
        } else if ($query->getType() == Constants::QUERY_TYPE_CREATE) {
            $translatedQuery = $this->translateCreate($query);
        } else {
            throw new Exception($query->getType() . ' query type is not allowed yet for mysql translator');
        }
        return $translatedQuery;
    }

    protected function translateShow(Query $query)
    {
        $templateQuery = 'SHOW %parameter1%;';
        $mysqlQuery = $this->injectParameters($templateQuery, $query->getParameters());

        return $mysqlQuery;
    }

    protected function translateUse(Query $query)
    {
        $templateQuery = 'USE %parameter1%;';
        $mysqlQuery = $this->injectParameters($templateQuery, $query->getParameters());

        return $mysqlQuery;
    }

    protected function translateCreate(Query $query)
    {
        if ($query->getParameter('type') == 'DATABASE') {
            $templateQuery = 'CREATE %parameter1% IF NOT EXISTS %parameter2%;';
        } else {
            throw new Exception('Mysql create of type ' . $query->getParameter('type') . ' is not implement yet');
        }
        $mysqlQuery = $this->injectParameters($templateQuery, $query->getParameters());

        return $mysqlQuery;
    }

    protected function injectParameters($queryString, array $parameters)
    {
        $toMatch = [];
        $queryParameters = [];
        preg_match_all('/%parameter\d%/', $queryString, $toMatch);

        if (count($toMatch)) {
            $queryParameters = $toMatch[0];
        }
        // loop through query template parameters
        foreach ($queryParameters as $index => $parameter) {

            if (!count($parameters)) {
                throw new Exception('Missing parameter ' . $index . ' for query ' . $queryString);
            }
            $replace = array_shift($parameters);
            $queryString = str_replace('%parameter' . ($index + 1) . '%', $replace, $queryString);
        }
        return $queryString;
    }
} 