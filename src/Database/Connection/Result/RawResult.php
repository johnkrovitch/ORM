<?php

namespace App\Database\Connection\Result;

use App\Behavior\Data;
use App\Behavior\HasQuery;

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
