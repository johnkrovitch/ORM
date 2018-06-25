<?php

namespace App\Behavior;

use App\Database\Connection\Driver;
use App\Database\Connection\SourceInterface;

trait HasSource
{
    /**
     * @var SourceInterface
     */
    protected $source;

    /**
     * Return current source
     *
     * @return SourceInterface
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set current source
     *
     * @param SourceInterface $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }
} 
