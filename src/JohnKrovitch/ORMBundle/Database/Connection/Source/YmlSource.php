<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Source;

use JohnKrovitch\ORMBundle\Behavior\SourceBehavior;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Constants;

class YmlSource implements Source
{
    use SourceBehavior;

    public function getType()
    {
        return Constants::DRIVER_TYPE_YML;
    }
}