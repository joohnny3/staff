<?php

namespace App\Http\Controllers;

use App\Services\Notify\NotifyService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Support\Facades\Log;

class NotifyController extends Controller
{
    public function __construct(protected NotifyService $NotifyService)
    {
    }

    /**
     * @OA\Post (
     *     path="/notify",
     *     tags={"Notify"},
     *     summary="新增通知訊息",
     *     description="
     *      Required 必填值: 'recipient_name', 'email', 'subject', 'template', 'content', 'service'
     *      通知服務類型 1:Gmail, 2:Line, 3:Jandi, 4:Slack
     *      Gmail template 可選值: 'exchange_rate', 'resig', 'social_media_case'",
     *     security={
     *         {
     *              "Authorization": {}
     *         }
     *      },
     *      @OA\RequestBody (
     *           required = true,
     *           @OA\JsonContent(
     *               required = {"username","password"},
     *               example={
     *                   "recipient_name": "張育誠",
     *                   "email": "theyouchman@gmail.com",
     *                   "carbon_copy": {"johnny31258@gmail","johnny.chang@js-adways.com.tw"},
     *                   "blind_carbon_copy": {"johnny31258@gmail","johnny.chang@js-adways.com.tw"},
     *                   "subject": "台灣銀行2024年02月份平均匯率表",
     *                   "template": "exchange_rate",
     *                   "content": {"year":"2024","month":"02"},
     *                   "attachment": {"2024ExchangeRate-每月一號提供.xlsx"},
     *                   "service": 1,
     *                   },
     *           )
     *       ),
     *      @OA\Response (
     *           response=200,
     *           description="請求成功",
     *           @OA\Header(
     *               header="test",
     *               description="Employee request ID",
     *              @OA\Schema(
     *                  type="integer",
     *                  format="int64"
     *                  )
     *           ),
     *           @OA\JsonContent(
     *                example={
     *                  "success": true,
     *                  "data": {
     *                      "recipient_name": "張育誠",
     *                      "email": "theyouchman@gmail.com",
     *                      "carbon_copy": {"johnny31258@gmail","johnny.chang@js-adways.com.tw"},
     *                      "blind_carbon_copy": {"johnny31258@gmail","johnny.chang@js-adways.com.tw"},
     *                      "subject": "台灣銀行2024年02月份平均匯率表",
     *                      "template": "exchange_rate",
     *                      "content": {"year":"2024","month":"02"},
     *                      "service": 1,
     *                  }
     *                  }
     *            ),
     *      ),
     *     @OA\Response (
     *          response=400,
     *          ref="#/components/responses/400",
     *     ),
     *     @OA\Response (
     *          response=401,
     *          ref="#/components/responses/401",
     *     ),
     *     @OA\Response (
     *          response=500,
     *          ref="#/components/responses/500",
     *     )
     * )
     */
    public function add(Request $request)
    {
        try {
            $data = $request->validate([
                'recipient_name' => 'required|string|max:15',
                'email' => 'required|string|email|max:100',
                'carbon_copy' => 'sometimes|string|nullable',
                'blind_carbon_copy' => 'sometimes|string|nullable',
                'subject' => 'required|string|max:50',
                'content' => 'required|json',
                'template' => 'required|string|max:20|in:exchange_rate,resign,social_media_case',
                'attachment' => 'sometimes|string|nullable',
                'service' => 'required|int|max:10|in:1,2,3,4'
            ]);

            //檢查模板參數與內文參數是否相同
            $template_parameter = [
                'exchange_rate' => 2,
                'social_media_case' => 2,
                'resign' => 1,
            ];

            $content_array = json_decode($data['content'] ?? '[]', true);
            if (count($content_array) != $template_parameter[$data['template']]) {
                throw ValidationException::withMessages([
                    'message' => "content 參數與 {$data['template']} template 所需的參數不符"
                ]);
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
