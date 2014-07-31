<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\DataSource\Connection\Driver;
use JohnKrovitch\ORMBundle\DataSource\Connection\Source;

trait HasSource
{
    /**
     * @var Source
     */
    protected $source;

    /**
     * Return current source
     *
     * @return Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set current source
     *
     * @param Source $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }
} 