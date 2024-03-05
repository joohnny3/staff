<?php

namespace App\Services\Notify;


use App\Services\Service;
use Illuminate\Database\Eloquent\Model;

class NotifyService extends Service
{
    public function add(array $data): Model
    {
        return $this->repository('NotifyRepository')->create($data);
    }

    public function send()
    {

    }
}
