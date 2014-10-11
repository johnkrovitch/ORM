<?php

namespace JohnKrovitch\ORMResourceBundle\ORMBehavior;

use JohnKrovitch\ORMBundle\DataSource\Schema\Behavior;

class TimestampableBehavior extends Behavior
{
    public function getName()
    {
        return 'timestampable';
    }
}