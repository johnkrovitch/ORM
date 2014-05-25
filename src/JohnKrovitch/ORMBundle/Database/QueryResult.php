<?php

namespace JohnKrovitch\ORMBundle\Database;

use JohnKrovitch\ORMBundle\Database\Behavior\Collection;

class QueryResult implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Collection;

    public function getResults()
    {

    }
}