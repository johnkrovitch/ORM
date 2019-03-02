<?php

namespace App\Behavior;

use App\Manager\SourceManager;

trait HasSourceManager
{
    /**
     * @var SourceManager
     */
    protected $sourceManager;

    /**
     * @param SourceManager $sourceManager
     */
    public function setSourceManager($sourceManager)
    {
        $this->sourceManager = $sourceManager;
    }

    /**
     * @return SourceManager
     */
    public function getSourceManager()
    {
        return $this->sourceManager;
    }
}
