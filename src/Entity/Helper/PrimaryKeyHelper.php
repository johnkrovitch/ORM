<?php

namespace App\Entity\Helper;

use App\Entity\Metadata\Metadata;
use Symfony\Component\PropertyAccess\PropertyAccess;

class PrimaryKeyHelper
{
    public static function getPrimaryKeyValues($entity, Metadata $metadata): array
    {
        $ids = [];
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($metadata->getPrimaryKeys() as $property => $primaryKey) {
            $ids[$property] = $accessor->getValue($entity, $property);
        }

        return $ids;
    }
}
