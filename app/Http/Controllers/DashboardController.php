<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Bill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $upcomingDues = Bill::where('status', 'Unpaid')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->with('lease.tenant', 'lease.unit')
            ->get();

        $stats = [
            'total_units' => Unit::count(),
            'occupied_units' => Unit::where('status', 'Occupied')->count(),
            'vacant_units' => Unit::where('status', 'Vacant')->count(),
            'total_tenants' => Tenant::count(),
            'pending_maintenance' => MaintenanceRequest::where('status', 'Pending')->count(),
            'recent_payments' => Payment::with('lease.tenant', 'lease.unit')->latest()->take(5)->get(),
            'monthly_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'new_tenants' => Tenant::latest()->take(3)->get(),
            'delinquent_tenants' => Lease::where('active', true)
                ->whereHas('tenant')
                ->with('tenant', 'unit')
                ->whereDoesntHave('payments', function($q) {
                    $q->whereMonth('payment_date', now()->month);
                })->get(),
            'upcoming_dues' => $upcomingDues,
        ];

        return view('dashboard', compact('stats'));
    }
}
