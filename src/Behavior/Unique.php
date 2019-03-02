<?php

namespace App\Behavior;

trait Unique
{
    protected $unique = false;

    public function isUnique()
    {
        return filter_var($this->unique, FILTER_VALIDATE_BOOLEAN);
    }

    public function setUnique($unique)
    {
        $this->unique = $unique;
    }
}
