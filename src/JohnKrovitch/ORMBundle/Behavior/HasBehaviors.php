<?php

namespace JohnKrovitch\ORMBundle\Behavior;

trait HasBehaviors
{
    protected $behaviors = [];

    /**
     * @return array
     */
    public function getBehaviors()
    {
        return $this->behaviors;
    }

    /**
     * @param array $behaviours
     */
    public function setBehaviors($behaviours)
    {
        $this->behaviors = $behaviours;
    }

    public function addBehavior($behavior)
    {
        $this->behaviors[] = $behavior;
    }
} 