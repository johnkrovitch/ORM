<?php

namespace JohnKrovitch\ORMBundle\Database;

use JohnKrovitch\ORMBundle\Behavior\HasType;

class Query
{
    use HasType;

    public function toString()
    {
        die('query to string not implemented');
        return '';
    }
} 