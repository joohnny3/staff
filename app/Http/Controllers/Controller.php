<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Employee ",
 *      description="Employee description",
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
 *      url = "https://api-host.dev.app",
 *      description="測試區主機"
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
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
