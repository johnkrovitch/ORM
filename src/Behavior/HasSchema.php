<?php

namespace App\Behavior;

use App\Database\Schema\Schema;

trait HasSchema
{
    protected $schema;

    /**
     * @return Schema
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param Schema $schema
     */
    public function setSchema(Schema $schema)
    {
        $this->schema = $schema;
    }
}
