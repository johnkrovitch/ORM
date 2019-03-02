<?php

namespace JohnKrovitch\ORMResourceBundle;

use JohnKrovitch\ORMResourceBundle\DependencyInjection\BehaviorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JohnKrovitchORMResourceBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new BehaviorCompilerPass());
    }
}
