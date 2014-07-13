<?php

namespace JohnKrovitch\ORMBundle\Database\Schema;

use JohnKrovitch\ORMBundle\Database\Behavior\HasBehaviors;
use JohnKrovitch\ORMBundle\Database\Behavior\HasName;
use JohnKrovitch\ORMBundle\Database\Behavior\HasType;

class Column
{
    use HasName, HasType, HasBehaviors;
} 