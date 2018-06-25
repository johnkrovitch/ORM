<?php

namespace App\Behavior;

use Exception;

trait Parameters
{
    protected $parameters = [];

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameter($name)
    {
        if (!array_key_exists($name, $this->parameters)) {
            throw new Exception('Parameter ' . $name . ' not found');
        }
        return $this->parameters[$name];
    }

    public function setParameter($name, $value)
    {
        if (!array_key_exists($name, $this->parameters)) {
            throw new Exception('Parameter ' . $name . ' not exist, you should add the parameter first');
        }
        $this->parameters[$name] = $value;
    }

    public function addParameter($name, $value)
    {
        if (array_key_exists($name, $this->parameters)) {
            throw new Exception('Parameter ' . $name . ' already added to Query');
        }
        $this->parameters[$name] = $value;
    }


} 
