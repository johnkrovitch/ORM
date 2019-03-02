<?php

namespace App\Behavior;

trait Name
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Return current name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set current name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
