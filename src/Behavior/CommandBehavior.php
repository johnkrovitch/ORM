<?php

namespace App\Behavior;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Container;

trait CommandBehavior
{
    /**
     * @var SymfonyStyle
     */
    protected $style;

    /**
     * @var Container
     */
    protected $container;
} 
