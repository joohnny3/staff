<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * @OA\Put (
     *     path="/department/{departmentId}",
     *     tags={"Department"},
     *     summary="更新部門資料",
     *     description="更新部門資料",
     *     security={
     *         {
     *              "Authorization": {}
     *         }
     *      },
     *      @OA\Parameter (
     *           name="DepartmentId",
     *           description="部門ID",
     *           required=true,
     *           in="path",
     *           @OA\Schema (
     *               type="integer",
     *               format="int64",
     *            ),
     *      ),
     *      @OA\RequestBody (
     *           required = true,
     *           @OA\JsonContent(
     *               required = {"username","password"},
     *               example={
     *                  "name": "資訊管理部",
     *                  "name_en": "IT",
     *                  "status": 1,
     *                  "type": 2,
     *                  "parent": "管理處",
     *                  "manager_id": 1
     *              },
     *           )
     *       ),
     *      @OA\Response (
     *           response=200,
     *           ref="#/components/responses/200"
     *      ),
     *     @OA\Response (
     *          response=400,
     *          ref="#/components/responses/400",
     *     ),
     *     @OA\Response (
     *          response=401,
     *          ref="#/components/responses/401",
     *     ),
     * )
     */
    public function edit_department()
    {

    }


    /**
     * @OA\Delete (
     *     path="/department/{departmentId}",
     *     tags={"Department"},
     *     summary="刪除部門資料",
     *     description="刪除部門資料",
     *     security={
     *         {
     *              "Authorization": {}
     *         }
     *      },
     *      @OA\Parameter (
     *           name="DepartmentId",
     *           description="部門ID",
     *           required=true,
     *           in="path",
     *           @OA\Schema (
     *               type="integer",
     *               format="int64",
     *            ),
     *      ),
     *      @OA\Response (
     *           response=200,
     *           ref="#/components/responses/200"
     *      ),
     *     @OA\Response (
     *          response=400,
     *          ref="#/components/responses/400",
     *     ),
     *     @OA\Response (
     *          response=401,
     *          ref="#/components/responses/401",
     *     ),
     * )
     */
    public function delete_department()
    {

    }
}
