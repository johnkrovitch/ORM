<?php

namespace JohnKrovitch\ORMBundle\Database\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasLogger;
use JohnKrovitch\ORMBundle\Behavior\HasTranslator;
use JohnKrovitch\ORMBundle\Database\Connection\Driver;
use JohnKrovitch\ORMBundle\Database\Connection\Source\MysqlSource;
use JohnKrovitch\ORMBundle\Database\Connection\Source;
use JohnKrovitch\ORMBundle\Database\Constants;
use JohnKrovitch\ORMBundle\Database\Query;
use JohnKrovitch\ORMBundle\Database\QueryBuilder;
use PDO;

class MysqlDriver implements Driver
{
    use HasTranslator, HasLogger;

    /**
     * @var Source
     */
    protected $source;

    /**
     * @var PDO
     */
    protected $pdo;

    protected $isConnected = false;

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
        $dsn = sprintf('mysql:host=%s;', $host);

        if ($port) {
            $dsn .= ';port=' . $port;
        }
        $login = $source->getLogin() ? : null;
        $password = $source->getPassword() ? : null;
        $options = [];
        // connection to database
        $this->pdo = new PDO($dsn, $source->getLogin(), $password, $options);

        // show all databases
        $queryBuilder = new QueryBuilder();
        $queryBuilder->show('DATABASES');
        $result = $this->query($queryBuilder->getQuery());

        if (!$result) {
            die('error');
        }

        var_dump('result', $result);
        die;


        // use current database
        $query = new Query();
        $query->setType(Constants::QUERY_TYPE_USE);
        $query->addParameter('database', 'PANDA');
        $mysqlQuery = $this->getTranslator()->translate($query);
        $result = $this->pdo->query($mysqlQuery);
        var_dump($dsn, $login, $password, $options);

        die('lol');
        var_dump($source);
        var_dump($mysqlQuery);
        var_dump($result);
        var_dump($this->pdo->errorCode());
        var_dump($this->pdo->errorInfo());
        die('lol');
    }

    public function read(Query $query = null)
    {
        // database connection test
        $this->connect();

        if ($query->getType() == Constants::QUERY_TYPE_SHOW) {
            $translatedQuery = $this->getTranslator()->translate($query);
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

    protected function query(Query $query)
    {
        $translatedQuery = $this->getTranslator()->translate($query);
        $this->getLogger()->info('>>> ORM query : ' . $translatedQuery);
        $pdoStatement = $this->pdo->query($translatedQuery);

        return $pdoStatement;
    }
}