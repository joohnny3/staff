<?php
use App\Http\Controllers\BoardController;
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


// Route::resource('/staff', StaffController::class);


Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');

Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');

Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');

Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');

Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');


Route::post('/staff/{staff}/boards', [BoardController::class, 'store'])->name('board.store');

