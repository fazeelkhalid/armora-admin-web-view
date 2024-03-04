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

use App\Http\Controllers\AuthController;

Route::group([ 'middleware' => 'api', 'prefix' => 'auth' ], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});




Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/vb/{id}', [VulnerabilityController::class, 'delete']);
});

Route::middleware(['auth'])->group(function () {
    Route::delete('/vulnerability/{id}', [VulnerabilityController::class, 'delete']);
    Route::delete('/system/{id}', [DeviceController::class, 'delete']);
    Route::delete('/report/{id}', [ScanReportController::class, 'delete']);
});


Route::middleware([APIKeyMiddleware::class])->group(function () {
    Route::group([ 'middleware' => 'api', 'prefix' => 'device' ], function ($router) {
        Route::post('/login', [DeviceController::class, 'deviceLogin']);
        
        Route::middleware(['auth:api'])->group(function () {
        
            Route::put('/login-status', [DeviceController::class, 'updateDeviceStatus']);
            Route::put('/logout', [DeviceController::class, 'logout']);
            

            Route::post('/verify', [DeviceController::class, 'verifyDeviceByKey']);
            Route::get('/verification', [DeviceController::class, 'checkDeviceVerification']);
            Route::get('/dashboard', [DashboardController::class, 'appDashboard']);
            
            Route::middleware([StartScan::class])->group(function () {
                Route::post('/scan', [ScanController::class, 'storeScanRequest']);
            });

        });
    });
});