<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(StaffController::class)->prefix('staff')->group(function () {
    Route::get('', 'index')->name('staff.index');
    Route::post('', 'addStaff')->name('staff.store');
    Route::get('create', 'addStaffView')->name('staff.create');
    Route::put('{staff}', 'editStaff')->name('staff.update');
    Route::get('{staff}/edit', 'editStaffView')->name('staff.edit');
    Route::delete('{staff}', 'deleteStaff')->name('staff.destroy');
    Route::get('{staff}', 'getStaff')->name('staff.show');
});

Route::post('/staff_export', [StaffController::class, 'export'])->name('staff.export');

Route::post('/staff_checkbox', [StaffController::class, 'checkBoxSession'])->name('staff.checkbox');

Route::post('/staff/{staff}/boards', [BoardController::class, 'addMessage'])->name('board.store');
