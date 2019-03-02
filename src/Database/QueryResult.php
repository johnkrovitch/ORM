<?php

namespace App\Database;

use Exception;

interface QueryResult extends \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * Return results from query.
     *
     * @param $hydrationMode
     *
     * @return array
     *
     * @throws Exception
     */
    public function getResults($hydrationMode);

    /**
     * Return affected rows count.
     *
     * @return int
     */
    public function getCount();

    /**
     * Return true if last query return an error.
     *
     * @return bool
     */
    public function hasErrors();

    /**
     * Return last query errors if there are.
     *
     * @return mixed
     */
    public function getErrors();
}
