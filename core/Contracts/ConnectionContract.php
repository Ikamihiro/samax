<?php

namespace Core\Contracts;

interface ConnectionContract
{
    /**
     * Connect to the database.
     * 
     * @return self
     */
    public function connect(): self;

    /**
     * Build the connection instance based on the configuration.
     * 
     * @param array $config
     * 
     * @return static
     */
    public static function make(array $config = []): self;

    /**
     * Get the PDO connection instance.
     * 
     * @return \PDO
     */
    public function getConnection(): \PDO;
}