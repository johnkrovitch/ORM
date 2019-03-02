<?php

namespace App\Behavior;

use JohnKrovitch\ORMResourceBundle\Manager\BehaviorManager;

trait HasBehaviorManager
{
    /**
     * @var BehaviorManager
     */
    protected $behaviorManager;

    /**
     * @param BehaviorManager $behaviorManager
     */
    public function setBehaviorManager($behaviorManager)
    {
        $this->behaviorManager = $behaviorManager;
    }

    /**
     * @return BehaviorManager
     */
    public function getBehaviorManager()
    {
        return $this->behaviorManager;
    }
} 
