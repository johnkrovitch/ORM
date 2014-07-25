<?php

namespace JohnKrovitch\ORMBundle\Database;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\Collection;


interface QueryResult extends \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * Return hydrate result from pdo statement
     *
     * @param $hydrationMode
     * @return array
     * @throws Exception
     */
    public function getResults($hydrationMode);

    /**
     * Return affected rows count
     *
     * @return int
     */
    public function getCount();

    /**
     * Return true if last query return an error
     *
     * @return bool
     */
    public function hasErrors();

    /**
     * Return last query errors if there are
     *
     * @return mixed
     */
    public function getErrors();
}