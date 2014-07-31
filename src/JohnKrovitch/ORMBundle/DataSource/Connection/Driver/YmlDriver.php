<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasLogger;
use JohnKrovitch\ORMBundle\Behavior\HasTranslator;
use JohnKrovitch\ORMBundle\DataSource\Connection\Driver;
use JohnKrovitch\ORMBundle\DataSource\Connection\Source;
use JohnKrovitch\ORMBundle\DataSource\Connection\Source\YmlSource;
use JohnKrovitch\ORMBundle\DataSource\Constants;
use JohnKrovitch\ORMBundle\DataSource\Query;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

class YmlDriver implements Driver
{
    use HasTranslator, HasLogger;

    /**
     * @var Source
     */
    protected $source;

    /**
     * Connect source
     *
     * @return mixed
     */
    public function connect()
    {
        die('yml driver connect');
    }

    public function query(Query $query)
    {
        if ($query->getType() != Constants::QUERY_TYPE_SHOW) {
            throw new Exception('Only SHOW query type is allowed yet for YmlDriver');
        }
        $fileSystem = new Filesystem();
        $parser = new Parser();

        if (!$fileSystem->exists($this->source->getHost())) {
            throw new Exception('Invalid yml source file location for source : ' . print_r($this->source, true));
        }
        $yaml = $parser->parse(file_get_contents($this->source->getHost()));

        return $yaml;
    }

    public function setSource($source)
    {
        // check if source is valid
        if (!($source instanceof YmlSource)) {
            throw new Exception('Invalid yml source' . $source);
        }
        $this->source = $source;
    }

    public function getType()
    {
        return $this->source->getType();
    }
}