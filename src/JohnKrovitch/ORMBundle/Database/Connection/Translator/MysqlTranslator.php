<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Translator;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasLogger;
use JohnKrovitch\ORMBundle\Behavior\HasSanitizer;
use JohnKrovitch\ORMBundle\Database\Connection\Translator;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Query;

class MysqlTranslator implements Translator
{
    use HasSanitizer;

    public function translate(Query $query)
    {
        if ($query->getType() == Constants::QUERY_TYPE_SHOW) {
            $translatedQuery = $this->translateShow($query);
        } else if ($query->getType() == Constants::QUERY_TYPE_USE) {
            $translatedQuery = $this->translateUse($query);
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
        $templateQuery = 'USE %database_name%;';
        $mysqlQuery = $this->injectParameters($templateQuery, ['database_name'], $query->getParameters());

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