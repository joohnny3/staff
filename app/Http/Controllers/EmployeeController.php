<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @OA\Post (
     *     path="/login",
     *     tags={"Employee"},
     *     summary="登入",
     *     description="Js-Adways3.0系統登入頁面",
     *     security={
     *         {
     *              "Authorization": {}
     *         }
     *      },
     *      @OA\RequestBody (
     *           required = true,
     *           @OA\JsonContent(
     *               required = {"username","password"},
     *               example={"username":"johnny.chang@js-adways.com.tw","password":"123456"},
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
     *                  "status":200,
     *                  "data":{
     *                      "token":"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9",
     *                      "system":{
     *                       {"id":1,"name":"電子簽核系統"},
     *                       {"id":2,"name":"工單系統"},
     *                      }
     *                  }
     *              },
     *            ),
     *      ),
     *     @OA\Response (
     *          response=400,
     *          description="客戶端錯誤"
     *     ),
     *     @OA\Response (
     *          response=401,
     *          description="身份驗證失敗"
     *     )
     * )
     */
    public function login()
    {

    }

    public function permission()
    {

    }

    public function employee()
    {

    }
}
