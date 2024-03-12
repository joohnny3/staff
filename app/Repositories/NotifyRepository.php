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

            $notifyData = [
                'recipient_name' => $data['recipient_name'],
                'subject' => $data['subject'],
                'content' => json_encode($data['content']),
                'template' => $data['template'],
                'service' => $data['service'],
            ];

            if (isset($data['email'])) {
                $notifyData['email'] = $data['email'];
            }
            if (isset($data['carbon_copy'])) {
                $notifyData['carbon_copy'] = json_encode($data['carbon_copy']);
            }
            if (isset($data['blind_carbon_copy'])) {
                $notifyData['blind_carbon_copy'] = json_encode($data['blind_carbon_copy']);
            }
            if (isset($data['upload'])) {
                $notifyData['attachment'] = json_encode($data['upload']);
            }

            $notify = Notify::create($notifyData);

            DB::commit();
            return $notify;
        } catch (Exception $t) {
            DB::rollBack();
            throw new Exception('Repository: ' . $t->getMessage());
        }
    }
}
