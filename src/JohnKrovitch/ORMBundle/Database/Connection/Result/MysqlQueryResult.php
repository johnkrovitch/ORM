<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Result;

use Exception;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\QueryResult;
use PDO;

class MysqlQueryResult extends QueryResult
{

    /**
     * Return hydrate result from pdo statement
     *
     * @param $hydrationMode
     * @throws Exception
     * @return array
     */
    public function getResults($hydrationMode)
    {
        if ($hydrationMode == Constants::FETCH_TYPE_OBJECT) {
            $results = $this->statement->fetchAll(PDO::FETCH_OBJ);
        } else if ($hydrationMode == Constants::FETCH_TYPE_ARRAY) {
            $results = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Invalid hydration mode (allowed ' . Constants::FETCH_TYPE_OBJECT . ', ' . Constants::FETCH_TYPE_ARRAY . ')');
        }
        return $results;
    }

    public function getCount()
    {
        return $this->statement->rowCount();
    }
} 