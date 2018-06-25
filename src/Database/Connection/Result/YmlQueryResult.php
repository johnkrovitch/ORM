<?php

namespace App\Database\Connection\Result;

use Exception;
use App\Database\Base\BaseQueryResult;
use App\Database\Constants;

class YmlQueryResult extends BaseQueryResult
{
    protected $yamlResult = [];

    /**
     * @param $rawData
     * @param array $keys
     */
    public function setResults($rawData, $keys = [])
    {
        // find data according to query
        $this->yamlResult = $this->findData($rawData, $keys);
    }

    /**
     * Return results from query
     *
     * @param $hydrationMode
     * @return array
     */
    public function getResults($hydrationMode)
    {
        $results = $this->yamlResult;

        if ($hydrationMode == Constants::FETCH_TYPE_OBJECT) {
            $results = (Object)$results;
        }
        return $results;
    }

    /**
     * Return affected rows count
     *
     * @return int
     */
    public function getCount()
    {
        return count($this->yamlResult, COUNT_RECURSIVE);
    }

    /**
     * Return true if last query return an error
     *
     * @return bool
     */
    public function hasErrors()
    {
        return count($this->getErrors());
    }

    /**
     * Return last query errors if there are
     *
     * @return mixed
     */
    public function getErrors()
    {
        die('get errors');
    }

    /**
     * Find data into yaml content
     *
     * @param $yaml
     * @param array $keys
     * @return array
     * @throws Exception
     */
    protected function findData($yaml, array $keys)
    {
        $data = [];

        if (count($keys)) {
            // TODO test this part
            foreach ($keys as $key => $value) {
                if (is_array($value)) {
                    $data = $this->findData($yaml, $keys[$key]);
                } else if (array_key_exists($key, $yaml)) {
                    $data[$key] = $value;
                }
            }
        } else {
            if (!array_key_exists('tables', $yaml)) {
                throw new Exception('Yaml should contain a root node "tables"');
            }
            // if nothing is provided, we get all yaml content
            $data = $yaml['tables'];
        }
        return $data;
    }
}
