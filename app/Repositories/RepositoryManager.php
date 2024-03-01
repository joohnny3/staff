<?php

namespace App\Repositories;

use Throwable;
use Exception;

final class RepositoryManager
{
    /**
     *
     * 取得repository
     *
     * @param string $name
     * @return object
     * @throws Throwable
     */
    public function get(string $name): object
    {
        try{
            $namespace = __NAMESPACE__;
            $repository = "${namespace}\\${name}";
            return new $repository();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }

    }
}
