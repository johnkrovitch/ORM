<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection;

use JohnKrovitch\ORMBundle\DataSource\Query;

interface Translator
{
    public function translate(Query $query);
}