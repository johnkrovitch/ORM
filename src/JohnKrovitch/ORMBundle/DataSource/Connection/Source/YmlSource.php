<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Source;

use JohnKrovitch\ORMBundle\Behavior\SourceBehavior;
use JohnKrovitch\ORMBundle\DataSource\Connection\Source;
use JohnKrovitch\ORMBundle\DataSource\Constants;

class YmlSource implements Source
{
    use SourceBehavior;

    public function getType()
    {
        return Constants::DRIVER_TYPE_YML;
    }
}