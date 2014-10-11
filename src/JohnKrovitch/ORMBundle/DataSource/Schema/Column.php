<?php

namespace JohnKrovitch\ORMBundle\DataSource\Schema;

use JohnKrovitch\ORMBundle\Behavior\Behaviors;
use JohnKrovitch\ORMBundle\Behavior\IsNullable;
use JohnKrovitch\ORMBundle\Behavior\Name;
use JohnKrovitch\ORMBundle\Behavior\Type;
use JohnKrovitch\ORMBundle\Behavior\Unique;

class Column
{
    use Name, Type, Behaviors, IsNullable, Unique;
} 