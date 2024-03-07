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
                'carbon_copy' => json_encode($data['carbon_copy']) ?? null,
                'blind_carbon_copy' => json_encode($data['blind_carbon_copy']) ?? null,
                'subject' => $data['subject'],
                'content' => json_encode($data['content']),
                'template' => $data['template'],
                'service' => $data['service'],
                'attachment' => json_encode($data['attachment']) ?? null,
            ]);

            DB::commit();
            return $notify;
        } catch (Exception $t) {
            DB::rollBack();
            throw new Exception('Repository: ' . $t->getMessage());
        }
    }
}
