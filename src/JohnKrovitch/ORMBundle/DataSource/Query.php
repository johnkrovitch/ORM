<?php

namespace JohnKrovitch\ORMBundle\DataSource;

use JohnKrovitch\ORMBundle\Behavior\Parameters;
use JohnKrovitch\ORMBundle\Behavior\Type;

class Query
{
    use Type, Parameters;

    /**
     * @return string
     */
    public function toString()
    {
        die('query to string not implemented');
        //return '';
    }
} 