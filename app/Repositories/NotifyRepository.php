<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Exception;
use App\Models\Notify;

class NotifyRepository
{
    public function create($data)
    {
        try {
            DB::beginTransaction();

            $notify = Notify::create([
                'recipient' => $data['recipient'],
                'email' => $data['email'],
                'carbon_copy' => $data['carbon_copy'],
                'blind_carbon_copy' => $data['blind_carbon_copy'],
                'subject' => $data['subject'],
                'content' => $data['content'],
                'template' => $data['template'],
                'service' => 1,
                'attachment' => $data['attachment'],
            ]);

            DB::commit();
            return $notify;
        } catch (Throwable $t) {
            DB::rollBack();
            throw new Exception($t->getMessage());
        }
    }
}
