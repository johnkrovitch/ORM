<?php

namespace JohnKrovitch\ORMBundle\Event;

use JohnKrovitch\ORMBundle\Behavior\HasSchema;
use JohnKrovitch\ORMBundle\DataSource\Schema\Schema;

class SchemaEvent extends Event
{
    use HasSchema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }
} 