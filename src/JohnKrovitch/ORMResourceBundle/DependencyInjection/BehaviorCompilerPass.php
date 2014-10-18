<?php

namespace JohnKrovitch\ORMResourceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * BehaviorCompilerPass
 *
 * Add behaviors (unique, timestampable...) tagged services into behavior manager call dependencies. It allows ORM user
 * to define behavior with the service tag 'orm.behavior'
 */
class BehaviorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tagged = $container->findTaggedServiceIds('orm.behavior');
        $behaviorManagerDefinition = $container->getDefinition('orm.manager.behavior');
        /**
         * @var string $serviceId
         * @var Definition $serviceDefinition
         */
        foreach ($tagged as $serviceId => $serviceDefinition) {
            // adding behavior dependency to behavior manager
            $behaviorManagerDefinition->addMethodCall('addBehavior', [new Reference($serviceId)]);
        }
    }
}