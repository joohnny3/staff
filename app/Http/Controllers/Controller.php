<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Notify Center",
 *      description="通知中心 api description",
 *      @OA\Contact(
 *          email="developer@example.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\PathItem(
 *      path="/"
 *  )
 * * @OA\server(
 *      url = "http://127.0.0.1/staff/api",
 *      description="測試區"
 * )
 * @OA\server(
 *      url = "http://localhost/XXXXX",
 *      description="Localhost"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="Authorization",
 *      type="apiKey",
 *      in="header",
 *      name="Authorization"
 * )
 * @OA\Components(
 *     @OA\Response(
 *          response="200",
 *          description="成功",
 *          @OA\JsonContent(
 *              example={
 *                  "status":200,
 *                  "message":"OK",
 *              }
 *          ),
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="客戶端錯誤",
 *         @OA\JsonContent(
 *               example={
 *                   "status":400,
 *                   "message":"Bad Request",
 *               }
 *           ),
 *     ),
 *     @OA\Response(
 *          response="401",
 *          description="身份驗證失敗",
 *          @OA\JsonContent(
 *              example={
 *                  "status":401,
 *                  "message":"Unauthorized",
 *              }
 *          ),
 *     ),
 *     @OA\Response(
 *          response="404",
 *          description="找不到請求的資源",
 *          @OA\JsonContent(
 *              example={
 *                  "status":404,
 *                  "message":"Not Found",
 *              }
 *          ),
 *     ),
 *     @OA\Response(
 *          response="405",
 *          description="不支援此方法",
 *          @OA\JsonContent(
 *              example={
 *                  "status":405,
 *                  "message":"Method Not Allowed",
 *              }
 *          ),
 *     ),
 *     @OA\Response(
 *           response="500",
 *           description="伺服器發生錯誤",
 *           @OA\JsonContent(
 *               example={
 *                   "status":500,
 *                   "message":"伺服器發生錯誤",
 *               }
 *           ),
 *      ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
