<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Translator;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasSanitizer;
use JohnKrovitch\ORMBundle\DataSource\Connection\Result\MysqlQueryResult;
use JohnKrovitch\ORMBundle\DataSource\Connection\Result\RawResult;
use JohnKrovitch\ORMBundle\DataSource\Connection\Translator;
use JohnKrovitch\ORMBundle\DataSource\Constants;
use JohnKrovitch\ORMBundle\DataSource\Query;
use JohnKrovitch\ORMBundle\DataSource\Schema\Column;
use JohnKrovitch\ORMBundle\DataSource\Schema\Table;

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
        } else if ($query->getType() == Constants::QUERY_TYPE_DESCRIBE) {
            $translatedQuery = $this->translateDescribe($query);
        } else {
            throw new Exception($query->getType() . ' query type is not allowed yet for mysql translator');
        }
        $query->setTranslatedQuery($query);

        return $translatedQuery;
    }

    public function reverseTranslate(RawResult $rawResult)
    {
        if (!$rawResult->getQuery()->isExecuted()) {
            throw new Exception('Query must be translated before being inverse translated');
        }
        $queryResult = new MysqlQueryResult();
        $queryResult->setQuery($rawResult->getQuery());
        $queryResult->setStatement($rawResult->getData());

        return $queryResult;
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
            // CREATE DATABASE
            $templateQuery = 'CREATE %parameter1% IF NOT EXISTS %parameter2%;';
        } else if ($query->getParameter('type') == 'TABLE') {
            // CREATE TABLE
            $table = $query->getParameter('value');

            if (!($table instanceof Table)) {
                $table = is_object($table) ? get_class($table) : gettype($table);
                throw new Exception('Parameter "value" should be an instance of Table, ' . $table . ' given');
            }
            $templateQuery = 'CREATE %parameter1% IF NOT EXISTS %parameter2% (';
            $templateQuery .= $this->getTableDefinition($table->getColumns()) . ');';
            // we transform Table object into string in query parameters
            $query->setParameter('value', $table->getName());
        } else {
            throw new Exception('Mysql create of type ' . $query->getParameter('type') . ' is not allowed');
        }
        $mysqlQuery = $this->injectParameters($templateQuery, $query->getParameters());

        return $mysqlQuery;
    }

    protected function translateDescribe(Query $query)
    {
        if (count($query->getParameters())) {
            throw new Exception('Describe query should not have parameters');
        }
        $query->addParameter('value', 'DATABASES');
        $templateQuery = $this->translateShow($query);

        // create additional query to show table
        $additionalQuery = new Query();
        $additionalQuery->setType(Constants::QUERY_TYPE_SHOW);
        $additionalQuery->addParameter('value', 'TABLES');
        $this->translate($additionalQuery);
        // add to main query
        $query->addQuery($additionalQuery);

        return $templateQuery;
    }

    /**
     * Inject parameter into a query string with formatted strings
     *
     * @param $queryString
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
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
            $replace = $this->getSanitizer()->sanitize($replace);
            $queryString = str_replace('%parameter' . ($index + 1) . '%', $replace, $queryString);
        }
        return $queryString;
    }

    protected function getTableDefinition(array $columns)
    {
        $definition = '';
        $numberOfColumns = count($columns);
        $idColumns = [];


        /** @var Column $column */
        foreach ($columns as $index => $column) {
            $definition .= $this->getSanitizer()->sanitize($column->getName());

            if ($column->getType() == Constants::COLUMN_TYPE_ID) {
                $definition .= ' INT NOT NULL AUTO_INCREMENT PRIMARY KEY';
                $ids[] = $column;
            } else if ($column->getType() == Constants::COLUMN_TYPE_INTEGER) {
                $definition .= ' INT ';
            } else if ($column->getType() == Constants::COLUMN_TYPE_STRING) {
                $definition .= ' VARCHAR (255) ';
            } else if ($column->getType() == Constants::COLUMN_TYPE_TEXT) {
                $definition .= ' TEXT ';
            } else {
                throw new Exception('Column type translation is not handled for type :' . $column->getType());
            }
            if (!$column->isNullable()) {
                $definition .= ' NOT NULL ';
            }
            // adding semicolon if necessary
            if ($index != $numberOfColumns - 1 or count($idColumns)) {
                $definition .= ', ';
            }
        }
        if (count($idColumns)) {
            $definition .= ' PRIMARY KEY (';

            foreach ($idColumns as $column) {
                $definition .= $column->getName() . ',';
            }
            $definition = substr($definition, 0, strlen($definition) - 1);
            $definition .= ')';
        }
        return $definition;
    }
} 