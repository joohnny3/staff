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
     *     path="/notify/{service}/{type?}",
     *     tags={"Notify"},
     *     summary="新增通知訊息",
     *     description="
     Parameters 參數文件

     service:
     * 參數類型: string
     * 參數說明: 通知服務類型
     * 是否必傳: Y
     * 注意事項: {service} 服務類型可選: gmail, line, jandi, slack

     type:
     * 參數類型: string
     * 參數說明: 通知情境類型
     * 是否必傳: N
     * 注意事項: 目前只開放 gmail {type} 有通知情境可選: 1.exchange_rate(台灣銀行平均匯率通知), 2.social_media_case(最新社群案例通知), 3.resign(員工離退通知)

    recipient_name:
     * 參數類型: string
     * 參數說明: 接收人姓名
     * 是否必填: Y

    email:
     * 參數類型: string
     * 參數說明: 電子信箱
     * 是否必填: N

    carbon_copy:
     * 參數類型: JsonString: array
     * 參數說明: 副本
     * 是否必填: N

    blind_carbon_copy:
     * 參數類型: JsonString: array
     * 參數說明: 副本
     * 是否必填: N

    subject:
     * 參數類型: string
     * 參數說明: 通知訊息主旨
     * 是否必填: Y

    content:
     * 參數類型: Json: Object
     * 參數說明: 通知訊息內文
     * 是否必填: Y
     * 注意事項: 每種通知情境所需內文格式不同

    attachment:
     * 參數類型: JsonString: array
     * 參數說明: 附件
     * 是否必填: N

---------------------------------------------

    各情境通知內文(content)所需參數

    exchange_rate:
     * 範例: {'year':2024,'month':2}
     * 參數:     year       month
     * 說明:   匯率表年份   匯率表月份
     * 類型:    integer    integer

    social_media_case:
     * 範例: {'month':3,'cases':['案例標題',...]}
     * 參數:    month            cases
     * 說明: 案例分享當前月份    社群案例標題
     * 類型:   integer           array

    resign:
     * 範例: {'resignations':[{'employee_id':'','name':'','name_en':'','department':'','resignation_date':'','last_working_day':'','note':''},...]}
     * 參數:   employee_id     name      name_en     department     resignation_date    last_working_day    note
     * 說明:     員工編號      員工姓名   員工英文名字    員工所屬部門          離職日期            最後工作日        備註
     * 類型:     string       string     string        string              date               date         string
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
            if ($service == 'gmail' && $template == null) {
                throw ValidationException::withMessages([
                    'message' => "缺少{type},沒有輸入 gmail 通知情形"
                ]);
            }

            if ($service != 'gmail' && $template != null) {
                throw ValidationException::withMessages([
                    'message' => "目前service,不適用此{type}"
                ]);
            }

            $template_rules = [
                'exchange_rate' => [
                    'year' => 'required|integer',
                    'month' => 'required|integer',
                ],
                'resign' => [
                    'resignations' => 'required|array',
                    'resignations.*.employee_id' => 'required|string',
                    'resignations.*.name' => 'required|string|max:20',
                    'resignations.*.name_en' => 'required|string|max:50|regex:/^[A-Za-z0-9\.]*$/',
                    'resignations.*.department' => 'required|string|max:30',
                    'resignations.*.resignation_date' => 'required|date',
                    'resignations.*.last_working_day' => 'required|date',
                    'resignations.*.note' => 'sometimes|string|nullable',
                ],
                'social_media_case' => [
                    'month' => 'required|integer',
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

//        public function send()
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
