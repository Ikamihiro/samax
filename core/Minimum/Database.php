<?php

namespace Core\Minimum;

use Core\Minimum\Connection\AbstractConnection;
use PDO;
use PDOStatement;

class Database
{
    protected ?PDOStatement $stmt;

    protected string $query;

    protected array $params;

    protected AbstractConnection $db;

    public function __construct(AbstractConnection $db)
    {
        $this->db = $db;
        $this->db->connect();
        $this->stmt = null;
        $this->query = '';
        $this->params = [];
    }

    public function query(string $query, array $params = []): self
    {
        $this->query = $query;
        $this->params = $params;

        return $this;
    }

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

    public function execute(): void
    {
        $this->runQuery();
    }

    public function get(): array
    {
        $this->runQuery();

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first(): array
    {
        $this->runQuery();

        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}
