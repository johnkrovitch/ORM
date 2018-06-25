<?php

namespace App\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ORMConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('orm');
        $root
            ->children()
                ->arrayNode('databases')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('driver')->end()
                            ->scalarNode('dsn')->end()
                            ->scalarNode('schema')->end()
                        ->end()
                    ->end()
                ->end()
            ;

        return $builder;
    }
}
