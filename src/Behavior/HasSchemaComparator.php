<?php

namespace App\Behavior;

use App\Utils\SchemaComparator;

trait HasSchemaComparator
{
    protected $schemaComparator;

    /**
     * @return SchemaComparator
     */
    public function getSchemaComparator()
    {
        return $this->schemaComparator;
    }

    /**
     * @param SchemaComparator $schemaComparator
     */
    public function setSchemaComparator(SchemaComparator $schemaComparator)
    {
        $this->schemaComparator = $schemaComparator;
    }
}
