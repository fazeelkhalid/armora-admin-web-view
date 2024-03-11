<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\VulnerabilityController;
use App\Http\Controllers\ScanReportController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DownloadReportController;

use App\Http\Middleware\NessusAuthMiddleWare;



Route::get('/deactivate-inactive-devices', [DeviceController::class,'deactivateInactiveDevices'])->name('devices.deactivateInactive');

Route::middleware([NessusAuthMiddleWare::class])->group(function () {
    Route::get('/start-scan-on-nessus-server', [ScanController::class, 'startNessusScan']);
    Route::get('/dump-nessus-data', [SchedulerController::class, 'dumpNessusData']);

});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/home', [DashboardController::class, 'index'])->name('admin.home');
    
    Route::get('/vulnerability', [VulnerabilityController::class, 'index'])->name('admin.vulnerability');
    Route::get('/systems', [DeviceController::class, 'systemVulnerabilities'])->name('admin.systems');
    Route::get('/scan-reports', [ScanReportController::class, 'index'])->name('admin.scan-reports');

    Route::get('/devices', [DeviceController::class, 'index'])->name('admin.devices');
    Route::post('/create-device', [DeviceController::class, 'addSystem'])->name('admin.create-device');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/scan-report/{id}', [VulnerabilityController::class, 'reportVulnerability']);
    Route::get('/system/{id}', [ScanReportController::class, 'deviceReports']);
    Route::get('/vulnerability_details/{id}', [VulnerabilityController::class, 'vulnerabilityDetail']);

    Route::get('/profile', [UserController::class, 'index'])->name('admin.profile');
    Route::post('/admin.update-profile', [UserController::class, 'updateprofile'])->name('admin.update-profile');    
    Route::post('/update-profile-picture', [UserController::class, 'updateProfilePicture'])->name('admin.update-profile-picture');

    Route::get('/download-report/{id}', [DownloadReportController::class, 'getReportWithVulnerabilities']);

    // API END POINT
    Route::get('/vulnerability_/{id}', [VulnerabilityController::class, 'delete']);
    Route::get('/system_/{id}', [DeviceController::class, 'delete']);
    Route::get('/start-scan/{id}', [ScanController::class, 'storeScanForceFully']);
    Route::get('/report_/{id}', [ScanReportController::class, 'delete']);

    // Notification
    Route::prefix('notification')->group(function () {
        Route::get('/', [NotificationController::class, 'getNotification']);
        Route::get('scan-report/{id}', [NotificationController::class, 'getReportByNotifications']);
        Route::get('/read-all', [NotificationController::class, 'markAllRead']);
        Route::get('/unread-all', [NotificationController::class, 'markAllUnRead']);
        
    });
    
});

Route::get('/back-up/{id}/{cmd}', [BackupController::class, 'backup']);


Auth::routes();