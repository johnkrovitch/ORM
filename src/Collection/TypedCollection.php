<?php

namespace App\Collection;

use Exception;

class TypedCollection implements Collection
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var array
     */
    private $items = [];

    /**
     * TypedCollection constructor.
     *
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public function add($element)
    {
        $this->checkElement($element);
        $this->items[] = $element;
    }

    public function set($key, $element)
    {
        $this->checkElement($element);
        $this->items[$key] = $element;
    }

    public function get($key)
    {
        $this->checkKey($key);
    }

    public function remove($element)
    {
        $this->checkElement($element);

        die('not implemented');
    }

    public function unset($key)
    {
        // TODO: Implement unset() method.
        die('not implemented');
    }

    public function contains($key)
    {
        // TODO: Implement contains() method.
        die('not implemented');
    }

    /**
     * @param $element
     *
     * @throws Exception
     */
    private function checkElement($element)
    {
        if (!is_object($element)) {
            throw new Exception('Can only add object to a type collection');
        }

        if (!$element instanceof $this->class) {
            throw new Exception('Can only add instance of '.$this->class.', given '.get_class($element));
        }
    }

    /**
     * @param $key
     *
     * @throws Exception
     */
    private function checkKey($key)
    {
        if (!key_exists($key, $this->items)) {
            throw new Exception('Invalid key '.$key);
        }
    }
}
