<?php

namespace JohnKrovitch\ORMBundle\Database\Connection;

use JohnKrovitch\ORMBundle\Database\Query;

interface Translator
{
    public function translate(Query $query);
}