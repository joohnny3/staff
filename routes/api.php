<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** 通知中心 */
Route::post('/notify/{notifyService}/{type?}', [NotifyController::class, 'add'])
    ->where('notifyService', 'gmail|line|jandi|slack')
    ->where('type', 'exchange_rate|resign|social_media_case');
/** END通知中心 */
