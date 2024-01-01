<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @OA\Post (
     *     path="/login",
     *     tags={"Employee"},
     *     summary="登入頁面",
     *     description="這個api的詳細說明",
     *     security={
     *         {
     *              "Authorization": {}
     *         }
     *      },
     *      @OA\Parameter (
     *           name="帶入的參數名稱",
     *           description="帶入的參數說明",
     *           required=false,
     *           in="path",
     *           @OA\Schema (
     *                type="string"
     *           )
     *     ),
     *     @OA\Response (
     *          response=200,
     *          description="成功"
     *     ),
     *     @OA\Response(
     *          response=220,
     *          ref="#/components/responses/commonSuccess"
     *      ),
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
