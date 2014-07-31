<?php

namespace JohnKrovitch\ORMBundle\DataSource;

use JohnKrovitch\ORMBundle\Behavior\HasParameters;
use JohnKrovitch\ORMBundle\Behavior\HasType;

class Query
{
    use HasType, HasParameters;

    /**
     * @return string
     */
    public function toString()
    {
        die('query to string not implemented');
        //return '';
    }
} 