<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Source;

use JohnKrovitch\ORMBundle\Behavior\SourceBehavior;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Constants;

class MysqlSource implements Source
{
    use SourceBehavior;

    public function getHost()
    {
        // TODO: Implement getHost() method.
    }

    public function getPort()
    {
        // TODO: Implement getPort() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function getLogin()
    {
        // TODO: Implement getLogin() method.
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

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