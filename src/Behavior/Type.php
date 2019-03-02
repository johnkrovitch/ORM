<?php

namespace App\Behavior;

trait Type
{
    /**
     * @var string
     */
    protected $type;

    /**
     * Return current type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set current type.
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
