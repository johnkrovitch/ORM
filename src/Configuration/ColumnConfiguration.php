<?php

namespace App\Configuration;

use App\Database\Schema\Column;
use JK\Configuration\Configuration;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColumnConfiguration extends Configuration
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'type' => Column::COLUMN_TYPE_STRING,
                'options' => [],
            ])
            ->setAllowedTypes('type', 'string')
            ->setAllowedTypes('options', 'array')
            ->setNormalizer('options', function (Options $options, $value) {
                $resolver = new OptionsResolver();
                $resolver
                    ->setDefaults([
                        'primary_key' => false,
                        'foreign_key' => false,
                        'nullable' => false,
                        'indexed' => false,
                        'unique' => false,
                    ])
                    ->setAllowedTypes('primary_key', [
                        'string',
                        'boolean',
                    ])
                    ->setAllowedValues('primary_key', [
                        false,
                        'increment',
                    ])
                    ->setAllowedTypes('foreign_key', 'boolean')
                    ->setAllowedTypes('nullable', 'boolean')
                    ->setAllowedTypes('indexed', 'boolean')
                    ->setAllowedTypes('unique', 'boolean')
                    ->setNormalizer('unique', function (Options $options, $value) {
                        if (false !== $options->offsetGet('primary_key')) {
                            return true;
                        }

                        return $value;
                    })
                    ->setNormalizer('indexed', function (Options $options, $value) {
                        if (false !== $options->offsetGet('primary_key')) {
                            return true;
                        }

                        return $value;
                    })
                ;

                return $resolver->resolve($value);
            })
        ;
    }
}
