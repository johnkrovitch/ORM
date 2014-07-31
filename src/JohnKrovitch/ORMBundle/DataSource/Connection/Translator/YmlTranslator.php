<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Translator;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasLogger;
use JohnKrovitch\ORMBundle\Behavior\HasSanitizer;
use JohnKrovitch\ORMBundle\DataSource\Connection\Translator;
use JohnKrovitch\ORMBundle\DataSource\Constants;
use JohnKrovitch\ORMBundle\DataSource\Query;

class YmlTranslator implements Translator
{
    use HasSanitizer;

    public function translate(Query $query)
    {
        if ($query->getType() == Constants::QUERY_TYPE_SHOW) {

        } else {
            throw new Exception($query->getType() . ' query type is not allowed yet for yml translator');
        }
    }

    protected function translateShow(Query $query)
    {

    }
} 