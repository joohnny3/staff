<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;
use App\Models\Notify;

class NotifyRepository
{
    public function create(array $data): Model
    {
        try {
            DB::beginTransaction();

            $notify = Notify::create([
                'recipient' => $data['recipient'],
                'email' => $data['email'] ?? null,
                'carbon_copy' => $data['carbon_copy'] ?? null,
                'blind_carbon_copy' => $data['blind_carbon_copy'] ?? null,
                'subject' => $data['subject'],
                'content' => $data['content'],
                'template' => $data['template'],
                'service' => 1,
                'attachment' => $data['attachment'] ?? null,
            ]);

            DB::commit();
            return $notify;
        } catch (Throwable $t) {
            DB::rollBack();
            throw new Exception($t->getMessage());
        }
    }
}
