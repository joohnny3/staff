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
     *          ref="#/components/responses/400",
     *     ),
     *     @OA\Response (
     *          response=401,
     *          ref="#/components/responses/401",
     *     )
     * )
     */
    public function login()
    {
       /**
        1.input->前端 將帳號密碼加密 組成一組 key
        encrypt_key = request->key

        2.把key 解密->獲取員工帳號密碼
        decrypt_key = decrypt(encrypt_key)

        3.if解密成功用得到的帳號 去資料庫比對 where email = `帳號`
        employee = select * form employee where email = `帳號`

        4.if有此員工->進行密碼驗證hash_check
        if(employee){
            hash_check(employee->password)
        }

        5.else沒有此員工->回傳message:沒有找到此員工

        6.if密碼驗證成功->登入成功->生成jwt_token

        7.將jwt_token 存起來 作之後其他子系統需要驗證的時候用

        8.並且整理此員工可以使用的子系統->system

        9.密碼驗證失敗->回傳錯誤訊息:帳號或密碼錯誤

        10.output->status:200,
        data:{
        token:'jwt token', system:[{},{}],}
       */
    }

    /**
     * @OA\Post (
     *     path="/permission",
     *     tags={"Employee"},
     *     summary="取得權限",
     *     description="選取子系統獲取個人權限",
     *     security={
     *         {
     *              "Authorization": {}
     *         }
     *      },
     *      @OA\RequestBody (
     *           required = true,
     *           @OA\JsonContent(
     *               required = {"username","password"},
     *               example={"status": 200,
     *                        "data": {
     *                        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
     *                        "system_id": 1
     *                         }
     *                         },
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
     *                  "status": 200,
     *                  "data": {
     *                  "name": "Johnny",
     *                  "page": {
     *                  "系統管理",
     *                  "系統權限管理"
     *                  },
     *                  "function": {
     *                  "系統管理編輯功能",
     *                  "系統管理查閱"
     *                  }
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
     *     )
     * )
     */
    public function permission()
    {

    }

    /**
     * @OA\Get (
     *     path="/employee",
     *     tags={"Employee"},
     *     summary="員工列表",
     *     description="Js-Adways員工列表",
     *     security={
     *         {
     *              "Authorization": {}
     *         }
     *      },
     *      @OA\Parameter (
     *           name="keyword",
     *           description="關鍵字， 姓名，職稱",
     *           required=false,
     *           in="path",
     *           @OA\Schema (
     *               type="string"
     *           ),
     *       ),
     *      @OA\Parameter (
     *           name="status",
     *           description="員工在職狀態",
     *           required=false,
     *           in="path",
     *           @OA\Schema (
     *               type="integer",
     *               enum={1,2,3,4},
     *           ),
     *       ),
     *      @OA\Parameter (
     *           name="department",
     *           description="部門ID",
     *           required=false,
     *           in="path",
     *           @OA\Schema (
     *               type="integer",
     *               enum={1,2,3,4},
     *           ),
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
     *                   "code": 200,
     *                   "data":{
     *                          {"id": 1,
     *                          "name": "鄧雲澤",
     *                          "name_en": "van",
     *                          "job_title": "財務長",
     *                          "job_title_en": "Chief Financial Officer",
     *                          "status": 1
     *                          }
     *                          }
     *                          }
     *            ),
     *      ),
     *     @OA\Response (
     *          response=400,
     *          ref="#/components/responses/400",
     *     ),
     *     @OA\Response (
     *          response=404,
     *          ref="#/components/responses/404",
     *     ),
     *     @OA\Response (
     *          response=405,
     *          ref="#/components/responses/405",
     *     )
     * )
     */
    public function employee()
    {

    }

    /**
     * @OA\Patch (
     *     path="/employee/{employeeId}",
     *     tags={"Employee"},
     *     summary="更新員工資料",
     *     description="更新員工資料包含部門,權限群組,緊急聯絡人",
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
     *                   "employee_id": 2,
     *                   "employee_no": "A0002",
     *                   "name": "財務長",
     *                   "name_en": "Van",
     *                   "birthday": "1977-09-03",
     *                   "gender": 1,
     *                   "id_number": "A188888888",
     *                   "phone_number": "0977895561",
     *                   "address": "110台北市信義區忠孝東路五段510號21樓",
     *                   "email": "van@js-adways.com.tw",
     *                   "job_title": "財務長",
     *                   "job_title_en": "CFO",
     *                   "start_date": "2006-01-01  00:00:00",
     *                   "emergency_contact": {
     *                   {
     *                   "db_id": 2,
     *                   "name": "緊急聯絡人",
     *                   "phone_number": "0977289394",
     *                   "update_status": 0
     *                   }
     *                   },
     *                   "department": {
     *                   {
     *                   "id": 1,
     *                   "start_date": "2006-01-01",
     *                   "end_date": null,
     *                   "update_status": 1
     *                   }
     *                   },
     *                   "group": {
     *                   "create": {
     *                   1,
     *                   2
     *                   },
     *                   "delete": {
     *                   4,
     *                   5
     *                   }
     *                   }
     *                   }
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
     *              example={
     *                  "status":200,
     *                  "message":"成功"
     *              }
     *            ),
     *      ),
     *     @OA\Response (
     *          response=400,
     *          ref="#/components/responses/400",
     *     ),
     *     @OA\Response (
     *          response=401,
     *          ref="#/components/responses/401",
     *     )
     * )
     */
    public function edit_employee()
    {

    }
}
