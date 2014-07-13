<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Connection\Source\YmlSource;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

class MysqlDriver implements Driver
{
    /**
     * @var Source
     */
    protected $source;

    public function read()
    {
        die('Not implemented yet');
        $fileSystem = new Filesystem();
        $parser = new Parser();

        if (!$fileSystem->exists($this->source->getLocation())) {
            throw new Exception('Invalid yml source file location');
        }
        $yaml = $parser->parse(file_get_contents($this->source->getLocation()));

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
} 