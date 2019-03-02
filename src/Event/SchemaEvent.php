<?php

namespace App\Event;

use App\Behavior\HasSchema;
use App\Database\Schema\Schema;

class SchemaEvent extends Event
{
    use HasSchema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }
}
