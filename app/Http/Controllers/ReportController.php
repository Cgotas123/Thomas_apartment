<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\Unit;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use App\Models\Tenant;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function income(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $payments = Payment::with(['bill.lease.tenant', 'bill.lease.unit'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->orderBy('payment_date', 'desc')->get();

        $totalIncome = $payments->sum('amount');
        $byMethod = $payments->groupBy('payment_method')->map(fn($g) => $g->sum('amount'));

        return view('reports.income', compact('payments', 'totalIncome', 'byMethod', 'startDate', 'endDate'));
    }

    public function unpaid(Request $request)
    {
        $bills = Bill::with(['lease.tenant', 'lease.unit'])
            ->whereIn('status', ['unpaid', 'overdue'])
            ->orderBy('due_date', 'asc')->get();

        $totalUnpaid = $bills->sum('total_amount');
        $overdueCount = $bills->where('status', 'overdue')->count();

        return view('reports.unpaid', compact('bills', 'totalUnpaid', 'overdueCount'));
    }

    public function occupancy()
    {
        $units = Unit::with(['activeLease.tenant'])->orderBy('unit_number')->get();
        $total = $units->count();
        $occupied = $units->where('status', 'occupied')->count();
        $vacant = $units->where('status', 'vacant')->count();
        $maintenance = $units->where('status', 'maintenance')->count();
        $rate = $total > 0 ? round(($occupied / $total) * 100, 1) : 0;

        return view('reports.occupancy', compact('units', 'total', 'occupied', 'vacant', 'maintenance', 'rate'));
    }

    public function payments(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subMonths(3);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $payments = Payment::with(['bill.lease.tenant', 'bill.lease.unit', 'receiver'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->orderBy('payment_date', 'desc')->get();

        $totalAmount = $payments->sum('amount');
        $byMethod = $payments->groupBy('payment_method')->map(fn($g) => ['count' => $g->count(), 'total' => $g->sum('amount')]);

        return view('reports.payments', compact('payments', 'totalAmount', 'byMethod', 'startDate', 'endDate'));
    }

    public function maintenance(Request $request)
    {
        $query = MaintenanceRequest::with(['unit', 'reporter']);
        if ($request->filled('status')) { $query->where('status', $request->status); }

        $requests = $query->orderBy('created_at', 'desc')->get();
        $total = $requests->count();
        $pending = $requests->where('status', 'pending')->count();
        $inProgress = $requests->where('status', 'in_progress')->count();
        $completed = $requests->where('status', 'completed')->count();
        $byPriority = $requests->groupBy('priority')->map->count();

        return view('reports.maintenance', compact('requests', 'total', 'pending', 'inProgress', 'completed', 'byPriority'));
    }

    public function exportPdf($type, Request $request)
    {
        $data = [];
        $view = '';

        switch ($type) {
            case 'income':
                $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
                $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
                $payments = Payment::with(['bill.lease.tenant', 'bill.lease.unit'])->whereBetween('payment_date', [$startDate, $endDate])->get();
                $data = ['payments' => $payments, 'totalIncome' => $payments->sum('amount'), 'startDate' => $startDate, 'endDate' => $endDate];
                $view = 'reports.pdf.income';
                break;
            case 'unpaid':
                $bills = Bill::with(['lease.tenant', 'lease.unit'])->whereIn('status', ['unpaid', 'overdue'])->get();
                $data = ['bills' => $bills, 'totalUnpaid' => $bills->sum('total_amount')];
                $view = 'reports.pdf.unpaid';
                break;
            case 'occupancy':
                $units = Unit::with(['activeLease.tenant'])->orderBy('unit_number')->get();
                $total = $units->count();
                $occupied = $units->where('status', 'occupied')->count();
                $data = ['units' => $units, 'total' => $total, 'occupied' => $occupied, 'rate' => $total > 0 ? round(($occupied/$total)*100,1) : 0];
                $view = 'reports.pdf.occupancy';
                break;
            case 'payments':
                $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subMonths(3);
                $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
                $payments = Payment::with(['bill.lease.tenant', 'bill.lease.unit'])->whereBetween('payment_date', [$startDate, $endDate])->get();
                $data = ['payments' => $payments, 'totalAmount' => $payments->sum('amount'), 'startDate' => $startDate, 'endDate' => $endDate];
                $view = 'reports.pdf.payments';
                break;
            case 'maintenance':
                $requests = MaintenanceRequest::with(['unit', 'reporter'])->get();
                $data = ['requests' => $requests, 'total' => $requests->count()];
                $view = 'reports.pdf.maintenance';
                break;
        }

        $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'landscape');
        return $pdf->download("{$type}_report_" . date('Y-m-d') . ".pdf");
    }
}
