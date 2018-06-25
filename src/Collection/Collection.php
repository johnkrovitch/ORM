<?php

namespace App\Collection;

interface Collection
{
    public function add($element);
    public function set($key, $element);
    public function get($key);
    public function remove($element);
    public function unset($key);

    public function contains($key);
}
