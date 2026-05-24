<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Apartment Management Routes
    Route::resource('units', UnitController::class)->only(['index', 'edit', 'update']);
    Route::resource('tenants', TenantController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('maintenance', MaintenanceController::class);
    
    // Meter Readings
    Route::get('/meter_readings/bulk', [MeterReadingController::class, 'bulkCreate'])->name('meter_readings.bulk');
    Route::post('/meter_readings/bulk', [MeterReadingController::class, 'bulkStore'])->name('meter_readings.bulk.store');
    Route::post('/meter_readings/{meterReading}/post', [MeterReadingController::class, 'post'])->name('meter_readings.post');
    Route::resource('meter_readings', MeterReadingController::class);

    // Billing
    Route::post('/bills/generate', [BillController::class, 'generate'])->name('bills.generate');
    Route::resource('bills', BillController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');

    // Tenant Messaging
    Route::post('/tenants/{tenant}/send-message', [TenantController::class, 'sendMessage'])->name('tenants.sendMessage');

    // Settings & User Mgmt (Owner only usually)
    Route::resource('settings', SettingController::class);
    Route::resource('users-mgmt', UserManagementController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
