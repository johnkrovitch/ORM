<?php

namespace App\Contracts;

use App\Entity\Metadata\Metadata;

interface MetadataManagerInterface
{
    public function getMetadata(string $class): Metadata;
}
