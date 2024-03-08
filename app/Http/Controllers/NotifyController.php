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
     *
     *      通知服務類型 可選值: 1:Gmail, 2:Line, 3:Jandi, 4:Slack
     *
     *      Gmail template 可選值: 'exchange_rate', 'resig', 'social_media_case'
     *
     *      template content範例如下 ↓ ↓ ↓
     *
     *      exchange_rate: {'year':'2024','month':'02'}
     *
     *      resig: {'resignations':[{'employee_id':'','name':'','name_en':'','department':'','resignation_date':'','last_working_day':'','note':''},
     *                              {'employee_id':'','name':'','name_en':'','department':'','resignation_date':'','last_working_day':'','note':''}]}
     *
     *      social_media_case: {'month': '03','cases': ['黑橋牌年節活動貼文 一週吸引超過3,000人參與',
     *                                                  'Richart LINE OA推播訊息透過創意包裝互動成長3.7倍',
     *                                                  '報獎得獎率100%！金銀銅佳作全拿下！']}
     *     ",
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
    public function add(Request $request, string $service, ?string $template = null)
    {
        try {
            $template_rules = [
                'exchange_rate' => [
                    'year' => 'required|string',
                    'month' => 'required|string',
                ],
                'resign' => [
                    'resignations' => 'required|array',
                    'resignations.*.employee_id' => 'required|string',
                    'resignations.*.name' => 'required|string|max:20',
                    'resignations.*.name_en' => 'required|string|max:50|regex:/^[A-Za-z0-9\.]*$/',
                    'resignations.*.department' => 'required|string|max:30',
                    'resignations.*.resignation_date' => 'required|string',
                    'resignations.*.last_working_day' => 'required|string',
                    'resignations.*.note' => 'sometimes|string|nullable',
                ],
                'social_media_case' => [
                    'month' => 'required|string',
                    'cases' => 'required|array'
                ],
            ];

            $rules = [
                'recipient_name' => 'required|string|max:15',
                'email' => 'required|string|email|max:100',
                'carbon_copy' => 'sometimes|array|nullable',
                'carbon_copy.*' => 'sometimes|string|email',
                'blind_carbon_copy' => 'sometimes|array|nullable',
                'blind_carbon_copy.*' => 'sometimes|string|email',
                'subject' => 'required|string|max:50',
                'content' => 'required|array',
                'attachment' => 'sometimes|array|nullable',
                'attachment.*' => 'sometimes|string|regex:/\.[a-zA-Z0-9]+$/',
            ];

            if (isset($template_rules[$template])) {
                foreach ($template_rules[$template] as $key => $rule) {
                    $rules["content.$key"] = $rule;
                }
            }

            $data = $request->validate($rules);

            $result = $this->NotifyService->add($data, $service, $template);

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
