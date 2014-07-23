<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Source;

use JohnKrovitch\ORMBundle\Behavior\SourceBehavior;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Constants;

class MysqlSource implements Source
{
    use SourceBehavior;

    /**
     * Return current source type
     *
     * @return mixed
     */
    public function getType()
    {
        return Constants::DRIVER_TYPE_PDO_MYSQL;
    }
}