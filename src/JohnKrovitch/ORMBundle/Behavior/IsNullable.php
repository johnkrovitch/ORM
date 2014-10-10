<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\DataSource\Connection\Driver;

trait IsNullable
{
    /**
     * @var boolean
     */
    protected $isNullable = true;

    /**
     * Return current type
     *
     * @return string
     */
    public function isNullable()
    {
        return $this->isNullable;
    }

    /**
     * Set current type
     *
     * @param $isNullable
     */
    public function setNullable($isNullable)
    {
        $this->isNullable = $isNullable;
    }
} 