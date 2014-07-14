<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Connection\Source\YmlSource;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

class YmlDriver implements Driver
{
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
        // TODO: Implement connect() method.
    }

    public function read()
    {
        $fileSystem = new Filesystem();
        $parser = new Parser();

        if (!$fileSystem->exists($this->source->getHost())) {
            throw new Exception('Invalid yml source file location');
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