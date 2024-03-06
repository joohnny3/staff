<?php

namespace App\Http\Controllers;

use App\Services\Notify\NotifyService;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Log;

class NotifyController extends Controller
{
    public function __construct(protected NotifyService $NotifyService)
    {
    }


    public function add(Request $request)
    {
        try {
            $data = $request->validate([
                'recipient_name' => 'required|string|max:15',
                'email' => 'sometimes|string|email|max:100',
                'carbon_copy' => 'sometimes|string|nullable',
                'blind_carbon_copy' => 'sometimes|string|nullable',
                'subject' => 'required|string|max:50',
                'content' => 'required|string',
                'template' => 'required|string|max:20|in:exchange_rate,resigning',
                'attachment' => 'sometimes|string|nullable',
            ]);

            $template_parameter = [
                'exchange_rate' => 2,
                'resigning' => 3,
            ];

            $content_array = json_decode($data['content'] ?? '[]', true);
            if (count($content_array) != $template_parameter[$data['template']]) {
                return response()->json([
                    'success' => false,
                    'message' => "content 參數與 {$data['template']} template 所需的參數不符。",
                ], 400);
            }

            $result = $this->NotifyService->add($data);

            return response()->json([
                'success' => true,
                'data' => $result,
            ], 201);
        } catch (Throwable $t) {
            Log::error('Error:' . $t->getMessage() . ' at line:' . $t->getLine());
            return response()->json([
                'success' => false,
                'message' => $t->getMessage(),
                'error line' => $t->getLine(),
            ], 400);
        }
    }

    //    public function send()
//    {
//        try {
//            $notifies = Notify::whereNull('sent_time')->get();
//
//            foreach ($notifies as $notify) {
//                $carbonCopy = json_decode($notify->carbon_copy, true);
//                $blindCarbonCopy = json_decode($notify->blind_carbon_copy, true);
//                $attachment = json_decode($notify->attachment, true);
//                $content = json_decode($notify->content);
//
//                Mail::to($notify->email)
//                    ->send(new OrderShipped(
//                        $notify->recipient,
//                        $carbonCopy,
//                        $blindCarbonCopy,
//                        $notify->subject,
//                        $content,
//                        $notify->template,
//                        $attachment
//                    ));
//
//                $notify->update(['sent_time' => now()]);
//            }
//        } catch (Exception $e) {
//            Log::error('Error sending mail for Notify ID ' . $notify->id . ': ' . $e->getMessage());
//        }
//    }
}
