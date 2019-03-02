<?php

namespace App\Behavior;

trait IsNullable
{
    /**
     * @var bool
     */
    protected $isNullable = true;

    /**
     * Return current type.
     *
     * @return string
     */
    public function isNullable()
    {
        return $this->isNullable;
    }

    /**
     * Set current type.
     *
     * @param $isNullable
     */
    public function setNullable($isNullable)
    {
        $this->isNullable = $isNullable;
    }
}
