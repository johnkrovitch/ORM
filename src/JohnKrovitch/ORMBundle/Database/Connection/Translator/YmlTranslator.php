<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Translator;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasSanitizer;
use JohnKrovitch\ORMBundle\Database\Connection\Translator;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Query;

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