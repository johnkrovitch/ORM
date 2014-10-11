<?php

namespace JohnKrovitch\ORMResourceBundle\Behavior;

use Exception;
use JohnKrovitch\ORMBundle\DataSource\Schema\Behavior;

trait HasORMBehaviors
{
    protected $behaviors = [];

    /**
     * @return array
     */
    public function getBehaviors()
    {
        return $this->behaviors;
    }

    public function addBehavior(Behavior $behavior)
    {
        if (array_key_exists($behavior->getName(), $this->behaviors)) {
            throw new Exception('An behavior with the same name as already been added (name: ' . $behavior->getName() . ')');
        }
        $this->behaviors[$behavior->getName()] = $behavior;
    }
} 