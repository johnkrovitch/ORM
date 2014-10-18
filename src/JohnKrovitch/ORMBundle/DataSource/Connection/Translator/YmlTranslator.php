<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Translator;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasSanitizer;
use JohnKrovitch\ORMBundle\DataSource\Connection\Result\RawResult;
use JohnKrovitch\ORMBundle\DataSource\Connection\Result\YmlQueryResult;
use JohnKrovitch\ORMBundle\DataSource\Connection\Translator;
use JohnKrovitch\ORMBundle\DataSource\Constants;
use JohnKrovitch\ORMBundle\DataSource\Query;

class YmlTranslator implements Translator
{
    use HasSanitizer;

    /**
     * Translate a query into a recursive array of keys. Those keys will be read by yml driver from yml source file
     * eg: [
     *  'panda' => [
     *     'bamboo'
     *     ]
     * ] will be read $yaml['panda'][bamboo'] in yml driver
     *
     * @param Query $query
     * @return array
     * @throws Exception
     */
    public function translate(Query $query)
    {
        if ($query->getType() == Constants::QUERY_TYPE_DESCRIBE) {
            $translation = $this->translateDescribe();
        } else {
            throw new Exception($query->getType() . ' query type is not allowed yet for yml translator');
        }
        $query->setTranslatedQuery($translation);

        return $translation;
    }

    /**
     * Translate a RawResult from driver into a QueryResult
     *
     * @param RawResult $rawResult
     * @return YmlQueryResult|mixed
     * @throws Exception
     */
    public function reverseTranslate(RawResult $rawResult)
    {
        if (!$rawResult->getQuery()->isExecuted()) {
            throw new Exception('Query must be translated before being inverse translated');
        }
        // get translated query
        $rawData = $rawResult->getData();
        $keys = $rawResult->getQuery()->getTranslatedQuery();


        $result = new YmlQueryResult();
        $result->setQuery($rawResult->getQuery());
        $result->setResults($rawData);

        return $result;
    }


    protected function translateDescribe()
    {
        return [
        ];
    }
} 