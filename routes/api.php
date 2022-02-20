<?php

use App\Http\Controllers\Api\AbsentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\EmployeeController;
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
});


// ------Authencation------
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // --------Dashboard----------
    Route::get('dashboard-data', [DashboardController::class, 'read']);

    // --------user---------
    Route::get('read-user', [UserController::class, 'read']);
    Route::post('create-user', [UserController::class, 'create']);
    Route::post('update-user/{id}', [UserController::class, 'update']);
    Route::delete('delete-user/{id}', [UserController::class, 'delete']);

    // --------employee--------
    Route::get('read-employee', [EmployeeController::class, 'read']);
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
});



