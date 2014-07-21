<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Translator;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasSanitizer;
use JohnKrovitch\ORMBundle\Database\Connection\Translator;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Query;

class MysqlTranslator implements Translator
{
    use HasSanitizer;

    public function translate(Query $query)
    {
        if ($query->getType() == Constants::QUERY_TYPE_SHOW) {
            $result = $this->translateShow($query);
        } else if ($query->getType() == Constants::QUERY_TYPE_USE) {
            $result = $this->translateUse($query);
        } else {
            throw new Exception($query->getType() . ' query type is not allowed yet for mysql translator');
        }
    }

    protected function translateShow(Query $query)
    {


        die('mysql translator in progress');

        return 0;
    }

    protected function translateUse(Query $query)
    {


        die('mysql translator use');
        return 0;
    }
} 