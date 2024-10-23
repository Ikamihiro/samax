<?php

namespace Core\Minimum;

use Core\Minimum\Connection\AbstractConnection;
use PDO;
use PDOStatement;

class Database
{
    /**
     * The PDO statement instance.
     * 
     * @var PDOStatement|null
     */
    protected ?PDOStatement $stmt;

    /**
     * The query string.
     * 
     * @var string
     */
    protected string $query;

    /**
     * The query parameters.
     * 
     * @var array
     */
    protected array $params;

    /**
     * The database connection instance.
     * 
     * @var AbstractConnection
     */
    protected AbstractConnection $db;

    public function __construct(AbstractConnection $db)
    {
        $this->db = $db;
        $this->stmt = null;
        $this->query = '';
        $this->params = [];

        $this->db->connect();
    }

    /**
     * Set the query string and parameters.
     * 
     * @param string $query
     * @param array $params
     * 
     * @return self
     */
    public function query(string $query, array $params = []): self
    {
        $this->query = $query;
        $this->params = $params;

        return $this;
    }

    /**
     * Prepare query, bind parameters and execute it.
     * 
     * @return self
     */
    private function runQuery(): self
    {
        if (empty($this->query)) {
            throw new \Exception('Query cannot be empty.');
        }

        $this->stmt = $this->db->getConnection()->prepare($this->query);

        foreach ($this->params as $key => $value) {
            $this->stmt->bindValue($key, $value);
        }

        $this->stmt->execute();

        return $this;
    }

    /**
     * Execute the query without fetching the result.
     * 
     * @return void
     */
    public function execute(): void
    {
        $this->runQuery();
    }

    /**
     * Execute the query and return all results.
     * 
     * @return array
     */
    public function get(): array
    {
        $this->runQuery();

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute the query and return the first result.
     * 
     * @return array
     */
    public function first(): array
    {
        $this->runQuery();

        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}
