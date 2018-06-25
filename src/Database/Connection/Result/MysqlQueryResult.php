<?php

namespace App\Database\Connection\Result;

use Exception;
use App\Database\Base\BaseQueryResult;
use App\Database\Constants;
use PDO;
use PDOStatement;

class MysqlQueryResult extends BaseQueryResult
{
    /**
     * @var PDOStatement
     */
    protected $statement;

    /**
     * @return PDOStatement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param PDOStatement $statement
     */
    public function setStatement(PDOStatement $statement)
    {
        $this->statement = $statement;
    }

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
        return $this->organizeResults($results);
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

    protected function organizeResults($results)
    {
        $sorted = [];
        // in mysql, results are different according to query type
        if ($this->getQuery()->getType() == Constants::QUERY_TYPE_DESCRIBE) {
            $sorted = [];

            foreach ($results as $index => $result) {
                $sorted[] = $results[$index]['Database'];
            }
        }
        return $sorted;
    }
}
