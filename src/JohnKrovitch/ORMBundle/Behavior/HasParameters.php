<?php

namespace JohnKrovitch\ORMBundle\Behavior;

use Exception;

class HasParameters
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

    public function addParameter($name, $value)
    {
        if (array_key_exists($name, $this->parameters)) {
            throw new Exception('Parameter ' . $name . ' already added to Query');
        }
        $this->parameters[$name] = $value;
    }


} 