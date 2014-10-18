<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Result;

use JohnKrovitch\ORMBundle\Behavior\Data;
use JohnKrovitch\ORMBundle\Behavior\HasQuery;

/**
 * RawResult
 *
 * Raw result from a data source
 */
class RawResult
{
    use Data, HasQuery;

    protected $rawResults = [];

    /**
     * @return array
     */
    public function getRawResults()
    {
        return $this->rawResults;
    }

    /**
     * @param RawResult $rawResult
     */
    public function addRawResults(RawResult $rawResult)
    {
        $this->rawResults = $rawResult;
    }
} 