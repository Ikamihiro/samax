<?php

namespace Core\Minimum\Connection;

class MySQLConnection extends AbstractConnection
{
    /**
     * The attributes of the connection.
     */
    protected array $attributes = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ];

    /**
     * Build the connection instance based on the configuration.
     * 
     * @param array $config
     * 
     * @return static
     */
    public static function make(array $config = []): self
    {
        if (empty($config)) {
            throw new \InvalidArgumentException('The configuration is empty.');
        }

        return new static(
            "mysql:host={$config['host']};port=3306;dbname={$config['database']}",
            $config['username'],
            $config['password']
        );
    }
}