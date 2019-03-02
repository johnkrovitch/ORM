<?php

namespace App\Configuration;

use JK\Configuration\Configuration;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SourceConfiguration extends Configuration
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('type')
            ->setAllowedValues('type', [
                'yml',
                'mysql',
            ])
            ->setRequired('dsn')
            ->setAllowedTypes('dsn', 'string')
        ;
    }
}
