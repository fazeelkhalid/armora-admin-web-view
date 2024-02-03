<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\VulnerabilityController;
use App\Http\Controllers\ScanReportController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\APIKeyMiddleware;
use App\Http\Middleware\NessusAuthMiddleWare;
use App\Http\Middleware\Validator\StartScan;
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



Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/vb/{id}', [VulnerabilityController::class, 'delete']);
});

Route::middleware(['auth'])->group(function () {
    Route::delete('/vulnerability/{id}', [VulnerabilityController::class, 'delete']);
    Route::delete('/system/{id}', [DeviceController::class, 'delete']);
    Route::delete('/report/{id}', [ScanReportController::class, 'delete']);
});


Route::get('/getdevices/{device}', [DeviceController::class, 'getdevices']);






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([APIKeyMiddleware::class])->group(function () {
    Route::post('/device/verify', [DeviceController::class, 'verifyDeviceByKey']);
    Route::post('/device/verification', [DeviceController::class, 'checkDeviceVerification']);
    Route::post('/dashboard', [DashboardController::class, 'appDashboard']);
    
    Route::middleware([StartScan::class])->group(function () {
        Route::post('/scan', [ScanController::class, 'storeScanRequest']);
    });
});