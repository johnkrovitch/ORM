<?php

namespace JohnKrovitch\ORMBundle\Database\Schema;

use JohnKrovitch\ORMBundle\Behavior\HasBehaviors;
use JohnKrovitch\ORMBundle\Behavior\HasName;
use JohnKrovitch\ORMBundle\Behavior\HasType;

class Column
{
    use HasName, HasType, HasBehaviors;
} 