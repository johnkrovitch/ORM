<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Source;

use JohnKrovitch\ORMBundle\Database\Connection\Source;

class YmlSource implements Source
{
    protected $name;

    protected $type;

    protected $location;

    public function __construct($name, $type, $location, $login = null, $password = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->location = $location;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getLogin()
    {
        // TODO: Implement getLogin() method.
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }
}