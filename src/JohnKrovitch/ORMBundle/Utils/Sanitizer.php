<?php

namespace JohnKrovitch\ORMBundle\Utils;

class Sanitizer
{
    protected $notAllowedParameters = ['select', 'update', 'delete', 'insert', ';', 'show', 'use'];

    public function sanitize($string)
    {
        $string = str_ireplace($this->notAllowedParameters, '', $string);

        return $string;
    }
} 