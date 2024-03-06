<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;
use App\Models\Notify;

class NotifyRepository
{
    /**
     * 新增通知內容格式
     *
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function create(array $data): Model
    {
        try {
            DB::beginTransaction();

            $notify = Notify::create([
                'recipient_name' => $data['recipient_name'],
                'email' => $data['email'] ?? null,
                'carbon_copy' => $data['carbon_copy'] ?? null,
                'blind_carbon_copy' => $data['blind_carbon_copy'] ?? null,
                'subject' => $data['subject'],
                'content' => $data['content'],
                'template' => $data['template'],
                'service' => $data['service'],
                'attachment' => $data['attachment'] ?? null,
            ]);

            DB::commit();
            return $notify;
        } catch (Exception $t) {
            DB::rollBack();
            throw new Exception('Repository: ' . $t->getMessage());
        }
    }
}
