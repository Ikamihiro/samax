<?php

namespace Core\Minimum\Connection;

use Core\Contracts\ConnectionContract;
use PDO;

abstract class AbstractConnection implements ConnectionContract
{
    /**
     * The DNS of the connection.
     */
    protected string $dns;

    /**
     * The username of the connection.
     */
    protected ?string $username;

    /**
     * The password of the connection.
     */
    protected ?string $password;

    /**
     * The attributes of the connection.
     */
    protected array $attributes = [];

    /**
     * The PDO connection instance
     */
    protected PDO $connection;

    public function __construct(string $dns, ?string $username = null, ?string $password = null)
    {
        $this->dns = $dns;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Connect to the database.
     * 
     * @return self
     */
    public function connect(): self
    {
        $this->connection = new PDO($this->dns, $this->username, $this->password);

        foreach ($this->attributes as $attribute => $value) {
            $this->connection->setAttribute($attribute, $value);
        }

        return $this;
    }

    /**
     * Get the PDO connection instance.
     * 
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}
