<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasTranslator;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Connection\Source\MysqlSource;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Query;
use PDO;

class MysqlDriver implements Driver
{
    use HasTranslator;

    /**
     * @var Source
     */
    protected $source;

    /**
     * @var PDO
     */
    protected $pdo;

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
        // connection to database
        $this->pdo = new PDO($dsn, $login, $password, $options);

        // use current database
        $query = new Query();
        $query->setType(Constants::QUERY_TYPE_USE);
        $mysqlQuery = $this->getTranslator()->translate($query);
        $this->pdo->query($mysqlQuery);
    }

    public function read(Query $query = null)
    {
        // database connection test
        $this->connect();

        if ($query->getType() == Constants::QUERY_TYPE_SHOW) {
            $test = $this->getTranslator()->translate($query);
        } else {
            throw new Exception($query->getType() . ' query type is not implemented yet for mysql driver');
        }


        die('mysql reading Not implemented yet');
    }

    public function write()
    {
        die('Not implemented yet');
    }

    public function setSource($source)
    {
        // check if source is valid
        if (!($source instanceof MysqlSource)) {
            throw new Exception('Invalid mysql source' . var_dump($source, true));
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
        return Constants::DRIVER_TYPE_PDO_MYSQL;
    }
}