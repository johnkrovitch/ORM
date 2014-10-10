<?php

namespace JohnKrovitch\ORMBundle\DataSource\Schema;

use JohnKrovitch\ORMBundle\Behavior\HasBehaviors;
use JohnKrovitch\ORMBundle\Behavior\HasName;
use JohnKrovitch\ORMBundle\Behavior\IsNullable;
use JohnKrovitch\ORMBundle\Behavior\Type;

class Column
{
    use HasName, Type, HasBehaviors, IsNullable;
} 