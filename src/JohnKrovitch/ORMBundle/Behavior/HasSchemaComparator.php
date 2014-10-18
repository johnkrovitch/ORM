<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use JohnKrovitch\ORMBundle\Utils\SchemaComparator;

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