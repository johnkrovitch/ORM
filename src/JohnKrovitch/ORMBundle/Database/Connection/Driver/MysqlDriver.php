<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Connection\Source\MysqlSource;
use JohnKrovitch\ORMBundle\Database\Connection\Source\YmlSource;
use PDO;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

class MysqlDriver implements Driver
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
        $source = $this->getSource();
        $host = $source->getHost();
        $database = $source->getName();
        $port = $source->getPort() ? : null;
        $dsn = sprintf('mysql:host=%s;dbname=%s', $host, $database);

        if ($port) {
            $dsn .= ';port=' . $port;
        }
        $login = $source->getLogin() ? : null;
        $password = $source->getPassword() ? : null;
        $options = [];


        $database = new PDO($dsn, $login, $password, $options);
    }

    public function read()
    {
        die('Not implemented yet');
    }

    public function write()
    {
        die('Not implemented yet');
    }

    public function setSource($source)
    {
        // check if source is valid
        if (!($source instanceof MysqlSource)) {
            throw new Exception('Invalid mysql source' . $source);
        }
        $this->source = $source;
    }

    public function getSource()
    {
        return $this->source;
    }


    /**
     * Return driver source type
     *
     * @return mixed
     */
    public function getType()
    {
        // TODO: Implement getType() method.
    }
}