<?php

use App\Http\Controllers\Api\AbsentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\Mobile\AbsentController as MobileAbsentController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    // mdbdasl
});


// ------Authencation------
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [ForgotPasswordController::class, 'forgot']);
Route::post('/password/reset', [ForgotPasswordController::class, 'reset']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // ===============MOBILE================
    Route::get('mobile/read-absent', [MobileAbsentController::class, 'read']);
    // ===============/MOBILE/==============

    // --------Dashboard----------
    Route::get('dashboard-data', [DashboardController::class, 'read']);

    // --------Holiday----------
    Route::get('read-holiday-date', [HolidayController::class, 'readDate']);
    Route::get('read-holiday', [HolidayController::class, 'read']);
    Route::post('create-holiday', [HolidayController::class, 'create']);
    Route::post('update-holiday/{id}', [HolidayController::class, 'update']);
    Route::delete('delete-holiday/{id}', [HolidayController::class, 'delete']);

    // --------user---------
    Route::get('read-user', [UserController::class, 'read']);
    Route::post('create-user', [UserController::class, 'create']);
    Route::post('update-user/{id}', [UserController::class, 'update']);
    Route::delete('delete-user/{id}', [UserController::class, 'delete']);

    // ---------Position-------
    Route::get('read-position', [PositionController::class, 'read']);
    Route::post('create-position', [PositionController::class, 'create']);
    Route::post('update-position/{id}', [PositionController::class, 'update']);
    Route::delete('delete-position/{id}', [PositionController::class, 'delete']);

    // --------employee--------
    Route::get('active-employee', [EmployeeController::class, 'active']);
    Route::get('inactive-employee', [EmployeeController::class, 'inactive']);
    Route::post('create-employee', [EmployeeController::class, 'create']);
    Route::post('update-employee/{id}', [EmployeeController::class, 'update']);
    Route::delete('delete-employee/{id}', [EmployeeController::class, 'delete']);

    // --------Absent----------
    Route::get('read-absent', [AbsentController::class, 'read']);
    Route::post('create-absent', [AbsentController::class, 'create']);
    Route::post('update-absent/{id}', [AbsentController::class, 'update']);
    Route::delete('delete-absent/{id}', [AbsentController::class, 'delete']);

    // -------Report------------
    Route::post('read-report', [ReportController::class, 'report']);

    Route::post('update-profile/{id}', [AuthController::class, 'update']);
    Route::post('update-password/{id}', [AuthController::class, 'password']);
    Route::post('logout', [AuthController::class, 'logout']);
});



