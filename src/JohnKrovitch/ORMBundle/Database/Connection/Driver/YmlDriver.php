<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasTranslator;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Connection\Source\YmlSource;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Query;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

class YmlDriver implements Driver
{
    use HasTranslator;

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

    public function read(Query $query)
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

    public function write()
    {
        die('Not implemented yet');
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