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

    /**
     * @OA\Post (
     *     path="/notify/{service}/{type?}",
     *     tags={"Notify"},
     *     summary="創建通知訊息",
     *     description="
必填欄位: recipient_name, subject, content

{service} 服務種類可選: gmail, line, jandi, slack ☞(擇一)

目前 gmail {type} 有以下幾種通知情形可選: 1.exchange_rate(台灣銀行平均匯率通知), 2.social_media_case(最新社群案例通知), 3.resign(員工離退通知) ☞(擇一)

各種通知信件內文(content)所需參數如下 ▾

exchange_rate: {'year':'2024','month':'02'}

    year:匯率表年份 ⎜month:匯率表月份

social_media_case: {'month':'03','cases':['案例標題',...]}

    month:分享案例當下月份 ⎜cases:分享案例標題

resign: {'resignations':[{'employee_id':'','name':'','name_en':'','department':'','resignation_date':'','last_working_day':'','note':''},...]}

    resignations:離職員工名單 ⎜employee_id:員工編號 ⎜name:員工姓名 ⎜name_en:員工英文名字 ⎜department:員工所屬部門
                            ⎜resignation_date:離職日期 ⎜last_working_day:最後工作日 ⎜note:備註

",
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
     *                   "content": {"year":"2024","month":"02"},
     *                   "attachment": {"2024ExchangeRate-每月一號提供.xlsx"},
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
     *                  "message": "通知訊息創建成功",
     *                  "details": {
     *                      "recipient": "張育誠",
     *                      "email": "theyouchman@gmail.com",
     *                      "subject": "台灣銀行2024年02月份平均匯率表",
     *                      "service": "Gmail",
     *                      "type": "exchange_rate",
     *                      "sent_at": "2024-03-08 12:16:15"
     *                      }
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
                'email' => 'sometimes|string|email|max:100',
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
                'message' => '通知訊息創建成功',
                'details' => [
                    'recipient' => $result->recipient_name,
                    'email' => $result->email,
                    'subject' => $result->subject,
                    'service' => $result->service->name,
                    'type' => $result->template,
                    'sent_at' => $result->created_at->toDateTimeString(),
                ],
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
