<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\DataSource\Connection\Driver;

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