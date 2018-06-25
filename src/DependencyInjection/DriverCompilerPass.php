<?php

namespace App\DependencyInjection;

use App\Manager\DriverManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DriverCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(DriverManager::class)) {
            return;
        }
        $driverManager = $container->getDefinition(DriverManager::class);
        $drivers = $container->findTaggedServiceIds('orm.driver');

        foreach ($drivers as $serviceId => $serviceData) {
            $driverManager->addMethodCall('addDriver', [
                new Reference($serviceId),
            ]);
        }
    }
}
