<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Result;

use Exception;
use JohnKrovitch\ORMBundle\Database\Base\BaseQueryResult;
use JohnKrovitch\ORMBundle\Database\Constants;
use PDO;

class MysqlQueryResult extends BaseQueryResult
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

    /**
     * Return mysql query affected row count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * Return true if last query return an error
     *
     * @return bool
     */
    public function hasErrors()
    {
        return $this->statement->errorCode() !== PDO::ERR_NONE;
    }

    /**
     * Return last query errors if there are
     *
     * @return mixed
     */
    public function getErrors()
    {
        $errorInfo = [];

        if ($this->hasErrors()) {
            $errorInfo = $this->statement->errorInfo();
        }
        return $errorInfo;
    }
}