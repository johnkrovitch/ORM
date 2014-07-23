<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Translator;

use Exception;
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
        $templateQuery = 'SHOW %parameter1%';
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
        preg_match_all('/%parameter\d%/', $queryString, $toMatch);

        var_dump($toMatch);
        die;


        $names = [];
        $values = [];

        foreach ($parameters as $name => $parameter) {
            $values[] = $parameter;
            $names[] = $name;
        }
        foreach ($para as $index => $name) {
            if (!array_key_exists($index, $names)) {
                throw new Exception('No parameters was found, ' . count($toReplace) . ' expected');
            }
            if (!array_key_exists($index, $values)) {
                throw new Exception('Parameter ' . $names[$index] . ' was not present in parameters array');
            }
            $queryString = str_replace('%' . $name . '%', $values[$index], $queryString);
        }
        return $queryString;
    }
} 