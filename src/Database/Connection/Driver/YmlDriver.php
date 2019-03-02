<?php

namespace App\Database\Connection\Driver;

use Exception;
use App\Behavior\HasLogger;
use App\Behavior\HasTranslator;
use App\Database\Connection\Driver;
use App\Database\Connection\Result\RawResult;
use App\Database\Connection\Result\YmlQueryResult;
use App\Database\Connection\SourceInterface;
use App\Database\Connection\Source\YmlSourceInterface;
use App\Database\Constants;
use App\Database\Query;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

/**
 * YmlDriver.
 *
 * Execute query in yml file
 */
class YmlDriver implements Driver
{
    use HasTranslator, HasLogger;

    /**
     * @var SourceInterface
     */
    protected $source;

    /**
     * Connect source.
     *
     * @return mixed
     */
    public function connect()
    {
        die('yml driver connect');
    }

    /**
     * Execute a Query and return a QueryResult.
     *
     * @param Query $query
     *
     * @return YmlQueryResult|mixed
     *
     * @throws Exception
     */
    public function query(Query $query)
    {
        // TODO handle other type of queries
        if (Constants::QUERY_TYPE_DESCRIBE != $query->getType()) {
            throw new Exception('Only DESCRIBE query type is allowed yet for YmlDriver');
        }
        $parser = new Parser();
        $fileSystem = new Filesystem();
        $translatedQuery = $this->getTranslator()->translate($query);

        // test if yml source file exists
        if (!$fileSystem->exists($this->source->getHost())) {
            $this->getLogger()->addError('>>> ORM ERROR loading yml file '.$this->source->getHost());
            throw new Exception('Invalid yml source file location for source : '.print_r($this->source, true));
        }
        $this->getLogger()->addInfo('>>> ORM loading yml file '.$this->source->getHost());
        // load yml file
        $yaml = $parser->parse(file_get_contents($this->source->getHost()));
        // set raw data into an object
        $rawResult = new RawResult();
        $rawResult->setData($yaml);
        $rawResult->setQuery($query);
        $query->setExecuted(true);
        // translate results
        $queryResult = $this->getTranslator()->reverseTranslate($rawResult);

        return $queryResult;
    }

    public function setSource($source)
    {
        // check if source is valid
        if (!($source instanceof YmlSourceInterface)) {
            throw new Exception('Invalid yml source'.$source);
        }
        $this->source = $source;
    }

    public function getType()
    {
        return $this->source->getType();
    }
}
