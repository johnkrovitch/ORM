<?php

namespace App\Database\Behavior;

use App\Database\Schema\Behavior;

class PrimaryKey extends AbstractBehavior
{
    public function getName(): string
    {
        return 'primary_key';
    }

    public function getTargetType(): string
    {
        return Behavior::TARGET_TYPE_COLUMN;
    }
}
