<?php

namespace App\Database\Connection\Driver;

use App\Database\Command;
use App\Database\Connection\Translator\TranslatorInterface;
use App\Database\Result\Result;
use App\Exception\Exception;
use App\Database\Connection\Result\RawResult;
use App\Database\Constants;
use App\Database\Query;
use PDO;
use PDOStatement;

/**
 * Handle interaction with mysql database.
 */
class MysqlDriver extends AbstractDriver
{
    const RETURN_CODE_SUCCESS = '00000';

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var PDO
     */
    protected $connection;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param string $dsn
     */
    public function connect(string $dsn)
    {
        $context = $this->buildContext($dsn);
        $dsn = $this->buildPDOConnectionString($context);
        $pdo = new PDO($dsn, $context['login'], $context['password']);

        $this->connection = $pdo;
        // TODO sanitize
        $this->connection->query('use '.$context['database']);
    }

    /**
     * @param Command $command
     *
     * @return Result
     *
     * @throws Exception
     */
    public function command(Command $command): Result
    {
        $this->checkConnection();
        $translatedQuery = $this->translator->translateCommand($command);
        $statement = $this->connection->prepare($translatedQuery->getTranslatedQuery());

        foreach ($translatedQuery->getParameters() as $name => $value) {
            // TODO bind correct type
            $statement->bindParam($name, $value, PDO::PARAM_LOB);
        }
        $success = $statement->execute();

        if (true !== $success && $statement->errorCode() !== self::RETURN_CODE_SUCCESS) {
            $message = vsprintf('An error has occurred when executing a command. Error code: "%s", Error message: "%s"', [
                $statement->errorCode(),
                $statement->errorInfo(),
            ]);
            throw new Exception($message);
        }

        return new Result($statement);
    }

    public function query(Query $query): Result
    {
        $this->checkConnection();

        $translatedQuery = $this->translator->translateQuery($query);
        $statement = $this->connection->prepare($translatedQuery->getTranslatedQuery());

        foreach ($translatedQuery->getParameters() as $name => $value) {
            // TODO bind correct type
            $statement->bindParam($name, $value, PDO::PARAM_LOB);
        }
        $success = $statement->execute();

        if (true !== $success && $statement->errorCode() !== self::RETURN_CODE_SUCCESS) {
            $message = vsprintf('An error has occurred when executing a command. Error code: "%s", Error message: "%s"', [
                $statement->errorCode(),
                $statement->errorInfo()[2],
            ]);
            throw new Exception($message);
        }

        return new Result($statement);
    }

    public function setSource($source)
    {
        // check if source is valid
        if (!($source instanceof MysqlSourceInterface)) {
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

    protected function execute(Query $query)
    {
        // translate into SQL query
        $translatedQuery = $this->getTranslator()->translate($query);
        // TODO handle boolean result (in case of CREATE for example)
        // TODO add a try catch
        // TODO only log in dev mode
        $this->getLogger()->info('>>> ORM query : ' . $translatedQuery);
        // pdo mysql query
        /** @var PDOStatement $pdoStatement */
        $pdoStatement = $this->pdo->query($translatedQuery);
        $query->setExecuted(true);

        if ($pdoStatement->errorCode() != self::RETURN_CODE_SUCCESS) {
            $message = 'An error has occurred in query "' . $translatedQuery . '". ' . implode($this->pdo->errorInfo(), "\n");
            $this->getLogger()->error('>>> ORM ERROR query : ' . $translatedQuery . ', mysql code : ' . $pdoStatement->errorCode());

            throw new Exception($message);
        }
        // hydrate result object
        $rawResult = new RawResult();
        $rawResult->setData($pdoStatement);
        $rawResult->setQuery($query);

        return $rawResult;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'mysql';
    }

    /**
     * @param array $context
     *
     * @return string
     */
    protected function buildPDOConnectionString(array $context): string
    {
        $dsn = 'mysql:host=%s;port=%s;';
        $parameters = [
            $context['host'],
            $context['port'],
        ];

        if (key_exists('database', $context)) {
            $dsn .= 'database=%s';
            $parameters[] = $context['database'];
        }

        return vsprintf($dsn, $parameters);
    }

    /**
     * @param string $dsn
     *
     * @return array
     *
     * @throws Exception
     */
    protected function buildContext(string $dsn)
    {
        if (substr($dsn, 0, 8) !== 'mysql://') {
            throw new Exception('The dsn string should begin by mysql://');
        }
        if (false === strstr($dsn, '@')) {
            throw new Exception('The dsn string should be like user:password@host:port/database');
        }
        $shortDsn = substr($dsn, 8);
        $parts = explode('@', $shortDsn);
        $loginParts = explode(':', $parts[0]);
        $databaseParts = explode('/', $parts[1]);
        $hostParts = explode(':', $databaseParts[0]);

        $login = $loginParts[0];
        $password = $loginParts[1];
        $host = $hostParts[0];
        $port = '3306';
        $database = $databaseParts[1];

        if (1 < count($hostParts)) {
            $port = $hostParts[1];
        }

        return [
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'login' => $login,
            'password' => $password,
        ];
    }

    protected function checkConnection()
    {
        if (null  === $this->connection) {
            throw new Exception('The driver should be connected to query the database');
        }
    }
}
