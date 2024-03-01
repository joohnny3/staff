<?php

namespace App\Services\Notify;


use App\Services\Service;

class NotifyService extends Service
{
    public function add($data)
    {
        return $this->repository('NotifyRepository')->create($data);
    }

    public function send()
    {

    }
}
