<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MeterReadingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Apartment Management Routes
    Route::resource('units', UnitController::class);
    Route::resource('tenants', TenantController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('maintenance', MaintenanceController::class);
    
    // Bulk Meter Readings
    Route::get('/meter_readings/bulk', [MeterReadingController::class, 'bulkCreate'])->name('meter_readings.bulk');
    Route::post('/meter_readings/bulk', [MeterReadingController::class, 'bulkStore'])->name('meter_readings.bulk.store');
    Route::resource('meter_readings', MeterReadingController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
