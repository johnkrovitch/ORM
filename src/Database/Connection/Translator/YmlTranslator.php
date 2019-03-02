<?php

namespace App\Database\Connection\Translator;

use Exception;
use App\Behavior\HasSanitizer;
use App\Database\Connection\Result\RawResult;
use App\Database\Connection\Result\YmlQueryResult;
use App\Database\Connection\Translator;
use App\Database\Constants;
use App\Database\Query;

class YmlTranslator implements Translator
{
    use HasSanitizer;

    /**
     * Translate a query into a recursive array of keys. Those keys will be read by yml driver from yml source file
     * eg: [
     *  'panda' => [
     *     'bamboo'
     *     ]
     * ] will be read $yaml['panda'][bamboo'] in yml driver.
     *
     * @param Query $query
     *
     * @return array
     *
     * @throws Exception
     */
    public function translate(Query $query)
    {
        if (Constants::QUERY_TYPE_DESCRIBE == $query->getType()) {
            $translation = $this->translateDescribe();
        } else {
            throw new Exception($query->getType().' query type is not allowed yet for yml translator');
        }
        $query->setTranslatedQuery($translation);

        return $translation;
    }

    /**
     * Translate a RawResult from driver into a QueryResult.
     *
     * @param RawResult $rawResult
     *
     * @return YmlQueryResult|mixed
     *
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
