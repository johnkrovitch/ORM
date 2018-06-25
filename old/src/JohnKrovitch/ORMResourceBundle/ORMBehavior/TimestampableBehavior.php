<?php

namespace JohnKrovitch\ORMResourceBundle\ORMBehavior;

use App\Database\Schema\Behavior;

class TimestampableBehavior extends Behavior
{
    public function getName()
    {
        return 'timestampable';
    }
}
