<?php

namespace Vikuraa\Helpers;

use PDO;
use PDOException;
use Vikuraa\Exceptions\ConnectionException;
use Psr\Log\LoggerInterface;
use Vikuraa\Exceptions\DatabaseException;
use Exception;

class Db
{
    protected $container;
    protected $host;
    protected $port;
    protected $sslmode;
    protected $name;
    protected $user;
    protected $password;
    protected $pdo;
    protected $stmt;
    protected $logger;

    public function __construct($container, $user, $password)
    {
        $this->container = $container;
        $this->host = $this->container->get('settings')['db']['host'];
        $this->port = $this->container->get('settings')['db']['port'];
        $this->sslmode = $this->container->get('settings')['db']['sslmode'];
        $this->name = $this->container->get('settings')['db']['name'];
        $this->user = $user;
        $this->password = $password;
        $this->logger = $this->container->get(LoggerInterface::class);

        $dsn = 'pgsql:host=' . $this->host
        . ';port=' . $this->port
        . ';dbname=' . $this->name 
        . ';user=' . $this->user 
        . ';password=' . $this->password 
        . ';sslmode=' . $this->sslmode 
        . ';';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, null, null, $options);
        } catch (PDOException $e) {
            throw new ConnectionException('Database connection failed', $e->getCode(), $e);
        }
    }

    /**
     * Checks if the PDO connection is active.
     * NOTE: PDO::ATTR_CONNECTION_STATUS is deprecated in PHP 8.0+.
     * A more robust check might involve a simple dummy query (e.g., SELECT 1).
     * @todo change according to above note
     * @return bool
     */
    public function connected(): bool
    {
        return $this->pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) !== null;
    }

    /**
     * Executes a SELECT query and fetches all results.
     *
     * @param string $query The SQL query string.
     * @param array $params An associative array of parameters for prepared statements.
     * @return array An array of associative arrays representing the fetched rows.
     * @throws DatabaseException If the database query fails.
     * @throws Exception For any other unexpected errors.
     */
    public function query(string $query, array $params = [])
    {
        try {
            if (count($params) > 0) {
                $this->stmt = $this->pdo->prepare($query);
                $this->stmt->execute($params);
                return $this->stmt->fetchAll();
            }
            
            $this->stmt = $this->pdo->query($query);
            return $this->stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException('Database query failed: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Executes a DML (INSERT, UPDATE, DELETE) query.
     *
     * NOTE: There's a logical flow issue here. If $params is empty, it calls exec(),
     * but then immediately proceeds to prepare/execute, which is redundant
     * and incorrect for non-parameterized DML.
     * It should either use exec() OR prepare/execute, not both paths in sequence.
     * Also, $this->stmt is not set if exec() is used.
     *
     * @todo improve according to above note
     * @param string $query The SQL query string.
     * @param array $params An array of parameters for prepared statements.
     * @param bool $needInsertId Whether to return the last insert ID.
     * @return mixed The number of affected rows for UPDATE/DELETE, or the last insert ID for INSERT if requested.
     * @throws DatabaseException If the database query fails.
     * @throws Exception For any other unexpected errors.
     */
    public function execute(string $query, array $params = [], bool $needInsertId = false): mixed
    {
        try {
            if (count($params) === 0) {
                $result = $this->pdo->exec($query);
            }
            $this->stmt = $this->pdo->prepare($query);
            $result = $this->stmt->execute($params);

            if (strpos(strtoupper($query), 'INSERT') === 0 && $needInsertId) {
                return $this->pdo->lastInsertId();
            }

            return $result;
        } catch (PDOException $e) {
            throw new DatabaseException('Database query failed: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Executes a query and returns the row count.
     *
     * NOTE: PDOStatement::rowCount() is generally unreliable for SELECT statements
     * as it often returns 0 or -1 depending on the driver.
     * For SELECT queries, use COUNT(*) in your SQL or fetchAll() and then count the array.
     * This method is best suited for DML (INSERT, UPDATE, DELETE) operations.
     *
     * @todo change to a select count(*)
     * @param string $query The SQL query string.
     * @param array $params An array of parameters for prepared statements.
     * @return int The number of rows affected by a DML query, or potentially unreliable for SELECT.
     * @throws DatabaseException If the database query fails.
     * @throws Exception For any other unexpected errors.
     */
    public function count(string $query, array $params = []): int
    {
        try {
            $this->stmt = $this->pdo->prepare($query);
            if (count($params) > 0) {
                $this->stmt->execute($params);
                return $this->stmt->rowCount();
            }
            $this->stmt->execute();
            return $this->stmt->rowCount();
        } catch (PDOException $e) {
            throw new DatabaseException('Database query failed: ' . $e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function exec(string $query): int|false
    {
        return $this->pdo->exec($query);
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }
}