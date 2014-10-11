<?php

namespace JohnKrovitch\ORMResourceBundle\ORMBehavior;

use JohnKrovitch\ORMBundle\DataSource\Schema\Behavior;

class UniqueBehavior extends Behavior
{
    public function getName()
    {
        return 'unique';
    }
}