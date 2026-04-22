<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_units' => Unit::count(),
            'occupied_units' => Unit::where('status', 'Occupied')->count(),
            'vacant_units' => Unit::where('status', 'Vacant')->count(),
            'total_tenants' => Tenant::count(),
            'pending_maintenance' => MaintenanceRequest::where('status', 'Pending')->count(),
            'recent_payments' => Payment::with('lease.tenant', 'lease.unit')->latest()->take(5)->get(),
            'monthly_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'new_tenants' => Tenant::latest()->take(3)->get(), // For registration notifications
        ];

        return view('dashboard', compact('stats'));
    }
}
