<?php

namespace JohnKrovitch\ORMBundle\DataSource\Connection\Driver;

use Exception;
use JohnKrovitch\ORMBundle\Behavior\HasLogger;
use JohnKrovitch\ORMBundle\Behavior\HasTranslator;
use JohnKrovitch\ORMBundle\DataSource\Connection\Driver;
use JohnKrovitch\ORMBundle\DataSource\Connection\Result\MysqlQueryResult;
use JohnKrovitch\ORMBundle\DataSource\Connection\Source;
use JohnKrovitch\ORMBundle\DataSource\Connection\Source\MysqlSource;
use JohnKrovitch\ORMBundle\DataSource\Constants;
use JohnKrovitch\ORMBundle\DataSource\Query;
use JohnKrovitch\ORMBundle\DataSource\QueryBuilder;
use PDO;

/**
 * MysqlDriver
 *
 * Handle interaction with mysql database
 */
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
     * Connect to mysql database and create it if not exists
     *
     * @throws Exception
     * @return mixed
     */
    public function connect()
    {
        $source = $this->getSource();
        $dsn = sprintf('mysql:host=%s;', $source->getHost());

        // if a port is specified, add it to dsn
        if ($port = $source->getPort()) {
            $dsn .= ';port=' . $port;
        }
        $options = [];
        // connection to database
        $this->pdo = new PDO($dsn, $source->getLogin(), $source->getPassword(), $options);
        // TODO move error mode in configuration
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // at this point we are connected
        $this->isConnected = true;

        // show all databases to determine if we should create or update database
        $queryBuilder = new QueryBuilder();
        $queryBuilder->show('DATABASES');
        $queryResult = $this->query($queryBuilder->getQuery());

        $databases = $queryResult->getResults(Constants::FETCH_TYPE_ARRAY);
        $shouldCreate = true;

        // TODO do no create database each time
        // TODO move database logic creation elsewhere ?
        foreach ($databases as $database) {
            if (array_key_exists('DataSource', $database) and $database['Database'] == $source->getName()) {
                // database already exist, we do not need to create it
                $shouldCreate = false;
            }
        }
        if ($shouldCreate) {
            $queryBuilder = new QueryBuilder();
            $queryBuilder->create('DATABASE', $source->getName());
            $queryResult = $this->query($queryBuilder->getQuery());

            if ($queryResult->getCount() !== 1) {
                throw new Exception('An error has occurred during database creation');
            }
        }
        // use current database. current query could not be build with queryBuilder because mysql "USE" notions
        // should not be related with generic queryBuilder
        $query = new Query();
        $query->setType(Constants::QUERY_TYPE_USE);
        $query->addParameter('database', $source->getName());
        // "use" query
        $this->query($query);
    }

    /**
     * Execute a query on mysql database
     *
     * @param Query $query
     * @throws Exception
     * @return mixed|void
     */
    public function query(Query $query)
    {
        if (!$this->isConnected) {
            // database connection if required
            $this->connect();
        }
        // translate into SQL query
        $translatedQuery = $this->getTranslator()->translate($query);

        // TODO only log in dev mode
        $this->getLogger()->info('>>> ORM query : ' . $translatedQuery);
        // hydrate result object
        // TODO handle boolean result (in case of CREATE for example)
        $pdoStatement = $this->pdo->query($translatedQuery);
        $queryResult = new MysqlQueryResult($pdoStatement);

        if (!$pdoStatement or $queryResult->hasErrors()) {
            $message = 'An error has occurred in query ' . $translatedQuery;
            $message .= implode($this->pdo->errorInfo(), "\n");

            throw new Exception($message);
        }
        return $queryResult;
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