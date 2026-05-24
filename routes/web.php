<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === ADMIN ONLY routes (must be BEFORE wildcard routes) ===
    Route::middleware(['role:admin'])->group(function () {
        // User management
        Route::resource('users', UserController::class);

        // Units - full CRUD (create, edit, delete)
        Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
        Route::post('/units', [UnitController::class, 'store'])->name('units.store');
        Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
        Route::put('/units/{unit}', [UnitController::class, 'update'])->name('units.update');
        Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');

        // Leases - full CRUD (create, edit, delete)
        Route::get('/leases/create', [LeaseController::class, 'create'])->name('leases.create');
        Route::post('/leases', [LeaseController::class, 'store'])->name('leases.store');
        Route::get('/leases/{lease}/edit', [LeaseController::class, 'edit'])->name('leases.edit');
        Route::put('/leases/{lease}', [LeaseController::class, 'update'])->name('leases.update');
        Route::delete('/leases/{lease}', [LeaseController::class, 'destroy'])->name('leases.destroy');

        // Bill delete
        Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->name('bills.destroy');

        // Payment delete
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    });

    // === BOTH Admin & Caretaker can access ===
    // Tenants (caretaker can manage)
    Route::resource('tenants', TenantController::class);

    // Meter Readings (caretaker can manage)
    Route::resource('meter-readings', MeterReadingController::class);

    // Maintenance (caretaker can manage)
    Route::resource('maintenance', MaintenanceController::class);

    // Bills - view & create for all, edit for all, delete admin only
    Route::resource('bills', BillController::class)->except(['destroy']);

    // Bill email notification
    Route::post('/bills/{bill}/send-email', [BillController::class, 'sendEmail'])->name('bills.send-email');

    // Payments - view & create for all, delete admin only
    Route::resource('payments', PaymentController::class)->except(['edit', 'update', 'destroy']);

    // Units - view only for caretaker (wildcard routes AFTER /create routes)
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/{unit}', [UnitController::class, 'show'])->name('units.show');

    // Leases - view only for caretaker (wildcard routes AFTER /create routes)
    Route::get('/leases', [LeaseController::class, 'index'])->name('leases.index');
    Route::get('/leases/{lease}', [LeaseController::class, 'show'])->name('leases.show');

    // Reports (view only)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/income', [ReportController::class, 'income'])->name('reports.income');
    Route::get('/reports/unpaid', [ReportController::class, 'unpaid'])->name('reports.unpaid');
    Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/maintenance', [ReportController::class, 'maintenance'])->name('reports.maintenance');
    Route::get('/reports/{type}/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
});
