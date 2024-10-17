<?php

namespace Core\Foundation\Env;

use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\RepositoryInterface;

class Env
{
    /**
     * The repository instance.
     */
    protected RepositoryInterface $repository;

    public function __construct()
    {
        $this->buildRepository();
    }

    /**
     * Build the repository instance.
     * 
     * @return void
     */
    protected function buildRepository(): void
    {
        $this->repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(EnvConstAdapter::class)
            ->addWriter(PutenvAdapter::class)
            ->immutable()
            ->make();
    }

    public function repository(): RepositoryInterface
    {
        return $this->repository;
    }
}
