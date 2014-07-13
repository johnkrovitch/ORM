<?php

namespace JohnKrovitch\ORMBundle\Database\Connection;

interface Source
{
    const TYPE_FILE = 'SOURCE_TYPE_FILE';
    const TYPE_DATABASE = 'SOURCE_TYPE_DATABASE';

    public function getName();

    public function getType();

    public function getLocation();

    public function getLogin();

    public function getPassword();
}