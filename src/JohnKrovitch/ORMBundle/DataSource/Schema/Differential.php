<?php

namespace JohnKrovitch\ORMBundle\DataSource\Schema;

class Differential
{
    protected $unmatchedOrigin;
    protected $unmatchedDestination;

    public function __construct(array $unmatchedOrigin, array $unmatchedDestination)
    {
        $this->unmatchedOrigin = $unmatchedOrigin;
        $this->unmatchedDestination = $unmatchedDestination;
    }

    public function getOriginUnMatchedTables()
    {
        return $this->unmatchedOrigin;
    }

    public function getDestinationUnMatchedTables()
    {
        return $this->unmatchedDestination;
    }
}