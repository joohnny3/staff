<?php

namespace App\Services\Notify;


use App\Services\Service;
use Illuminate\Database\Eloquent\Model;
use App\Enums\NotifyServiceType;

class NotifyService extends Service
{
    public function add(array $data, string $service, ?string $template): Model
    {
        $data['service'] = $service;
        $data['template'] = $template;

        if (!empty($data['attachment'])) {
            foreach ($data['attachment'] as $file) {
                $path = $file->store('uploads');
                $data['upload'][] = $path;
            }
        }

        return $this->repository('NotifyRepository')->create($data);
    }
}
