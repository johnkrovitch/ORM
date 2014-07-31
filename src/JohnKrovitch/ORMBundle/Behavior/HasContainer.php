<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\DataSource\Connection\Driver;
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