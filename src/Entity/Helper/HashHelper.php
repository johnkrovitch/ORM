<?php

namespace App\Entity\Helper;

use App\Entity\Metadata\Metadata;
use App\Exception\Exception;
use App\Exception\PrimaryKeyNotFoundException;

class HashHelper
{
    /**
     * Create an hash for the given entity, according ot the primary keys values.
     *
     * @param object   $entity The entity to get a hash from
     * @param Metadata $metadata The metadata associated to the entity
     *
     * @return string
     *
     * @throws PrimaryKeyNotFoundException
     */
    public static function hashEntity($entity, Metadata $metadata): string
    {
        $class = get_class($entity);
        $primaryKeys = $metadata->getPrimaryKeys();

        if (0 === count($primaryKeys)) {
            throw new PrimaryKeyNotFoundException($metadata);
        }

        $hash = $class.'__'.implode(PrimaryKeyHelper::getPrimaryKeyValues($entity, $metadata), '_');

        return $hash;
    }

    /**
     * Return entity data from a hash created with the hashEntity() method.
     *
     * @param string $hash
     *
     * @return array
     *
     * @throws Exception
     */
    public static function extractEntity(string $hash): array
    {
        $hashParts = explode('__', $hash);

        if (2 !== count($hashParts)) {
            throw new Exception('Unable to extract entity data from the hash "'.$hash.'"');
        }
        $class = $hashParts[0];
        $primaryKeysParts = explode('_', $hashParts[1]);

        if (0 === count($primaryKeysParts) || null === $primaryKeysParts[0] || '' === $primaryKeysParts[0]) {
            throw new Exception('Unable to extract entity primary keys from the hash "'.$hash.'"');
        }

        return [
            'class' => $class,
            'ids' => $primaryKeysParts,
        ];
    }
}
