<?php

namespace JohnKrovitch\ORMResourceBundle\ORMBehavior;

use App\Database\Schema\Behavior;

class UniqueBehavior extends Behavior
{
    public function getName()
    {
        return 'unique';
    }
}
