<?php

use App\Http\Controllers\AttendanceDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceListController;
use App\Http\Controllers\AttendanceRequestController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'index']);

Route::get('/attendance', [AttendanceController::class, 'index']);
Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn']);
Route::post('/attendance/rest-start', [AttendanceController::class, 'restStart']);
Route::post('/attendance/rest-end', [AttendanceController::class, 'restEnd']);
Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut']);

Route::get('/attendance/list', [AttendanceListController::class, 'index']);
Route::get('/attendance/detail/{id}', [AttendanceDetailController::class, 'show']);
Route::post('/attendance/detail/{id}', [AttendanceDetailController::class, 'store']);
Route::get('/attendance/detail/{id}', [AttendanceDetailController::class, 'show'])
    ->name('attendance.detail'); //詳細画面を表示する
Route::post('/attendance/detail/{id}', [AttendanceDetailController::class, 'store'])
    ->name('attendance.request.store'); //詳細申請を保存
Route::get('/stamp_correction_request/list', [AttendanceRequestController::class, 'index'])
    ->name('attendance.request.list');