<?php

namespace JohnKrovitch\ORMResourceBundle\DependencyInjection;

use JohnKrovitch\ORMBundle\DataSource\Schema\Behavior;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BehaviorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tagged = $container->findTaggedServiceIds('orm.behavior');
        $behaviorManager = $container->get('orm.manager.behavior');

        foreach ($tagged as $serviceId => $serviceDefinition) {
            /** @var Behavior $service */
            $service = $container->get($serviceId);

            if (!($service instanceof Behavior)) {
                throw new \Exception('Behavior ' . get_class($service) . ' should extends ' . Behavior::class);
            }
            $behaviorManager->addBehavior($service);
        }
    }
}