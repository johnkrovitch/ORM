<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\Database\Connection\Driver;

trait HasName
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Return current name
     *
     * @return Driver
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set current name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
} 