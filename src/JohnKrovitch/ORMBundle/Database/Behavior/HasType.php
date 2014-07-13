<?php

namespace JohnKrovitch\ORMBundle\Database\Behavior;

use JohnKrovitch\ORMBundle\Database\Connection\Driver;

trait HasType
{
    /**
     * @var string
     */
    protected $type;

    /**
     * Return current type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set current type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
} 