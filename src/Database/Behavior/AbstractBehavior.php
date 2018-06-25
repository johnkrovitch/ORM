<?php

namespace App\Database\Behavior;

use App\Database\Schema\Behavior;

abstract class AbstractBehavior implements Behavior
{
    protected $targets = [];

    /**
     * AbstractBehavior constructor.
     *
     * @param array $targets
     */
    public function __construct(array $targets = [])
    {
        $this->targets = $targets;
    }

    /**
     * @return array
     */
    public function getTargets(): array
    {
        return $this->targets;
    }
}
