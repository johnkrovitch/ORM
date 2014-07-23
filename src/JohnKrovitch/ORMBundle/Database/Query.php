<?php

namespace JohnKrovitch\ORMBundle\Database;

use JohnKrovitch\ORMBundle\Behavior\HasParameters;
use JohnKrovitch\ORMBundle\Behavior\HasType;

class Query
{
    use HasType, HasParameters;

    public function toString()
    {
        die('query to string not implemented');
        return '';
    }
} 