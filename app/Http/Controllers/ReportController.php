<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Lease;
use App\Models\Unit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function revenue(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $payments = Payment::whereMonth('payment_date', $month)
            ->whereYear('payment_date', $year)
            ->with('lease.tenant', 'lease.unit')
            ->get();

        $totalRevenue = $payments->sum('amount');

        return view('reports.revenue', compact('payments', 'totalRevenue', 'month', 'year'));
    }

    public function occupancy()
    {
        $units = Unit::all();
        $total = $units->count();
        $occupied = $units->where('status', 'Occupied')->count();
        $vacant = $units->where('status', 'Vacant')->count();
        $maintenance = $units->where('status', 'Maintenance')->count();

        return view('reports.occupancy', compact('units', 'total', 'occupied', 'vacant', 'maintenance'));
    }
}
