<?php

namespace App\Services;

use App\Repositories\RepositoryManager;
use Throwable;

abstract class Service
{
    /**
     *
     * 取得repository
     *
     * @param string $repository
     * @return object
     * @throws Throwable
     */
    protected function repository(string $repository): object
    {
        $repository_manager = new RepositoryManager();
        return $repository_manager->get($repository);
    }
}
