<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTenants = Tenant::count();
        $totalUnits = Unit::count();
        $occupiedUnits = Unit::where('status', 'occupied')->count();
        $vacantUnits = Unit::where('status', 'vacant')->count();
        $maintenanceUnits = Unit::where('status', 'maintenance')->count();

        // Monthly income (current month paid bills)
        $monthlyIncome = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        // Unpaid bills
        $unpaidBills = Bill::whereIn('status', ['unpaid', 'overdue'])->sum('total_amount');
        $unpaidBillsCount = Bill::whereIn('status', ['unpaid', 'overdue'])->count();

        // Pending maintenance
        $pendingMaintenance = MaintenanceRequest::whereIn('status', ['pending', 'in_progress'])->count();

        // Monthly income for last 6 months (for chart)
        $monthlyIncomeData = [];
        $monthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->format('M Y');
            $monthlyIncomeData[] = Payment::whereMonth('payment_date', $date->month)
                ->whereYear('payment_date', $date->year)
                ->sum('amount');
        }

        // Occupancy data for chart
        $occupancyData = [$occupiedUnits, $vacantUnits, $maintenanceUnits];

        // Recent activities
        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Recent unpaid bills
        $recentUnpaidBills = Bill::with(['lease.tenant', 'lease.unit'])
            ->whereIn('status', ['unpaid', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        // Payment method distribution
        $paymentMethods = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();

        $data = compact(
            'totalTenants', 'totalUnits', 'occupiedUnits', 'vacantUnits',
            'maintenanceUnits', 'monthlyIncome', 'unpaidBills', 'unpaidBillsCount',
            'pendingMaintenance', 'monthlyIncomeData', 'monthLabels',
            'occupancyData', 'recentActivities', 'recentUnpaidBills', 'paymentMethods'
        );

        if (auth()->user()->hasRole('admin')) {
            return view('dashboard.admin', $data);
        }

        return view('dashboard.caretaker', $data);
    }
}
