<?php

namespace App\DependencyInjection;

use App\DependencyInjection\Configuration\ORMConfiguration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ORMExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new ORMConfiguration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('orm.databases', $config['databases']);

        //$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        //$loader->load('services.yml');
    }
}
