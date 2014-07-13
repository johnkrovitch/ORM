<?php

namespace JohnKrovitch\ORMBundle\Database\Behavior;

use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use Symfony\Component\DependencyInjection\Container;

trait HasContainer
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Return current container
     *
     * @return Container container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set current container
     *
     * @param Container $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }
} 