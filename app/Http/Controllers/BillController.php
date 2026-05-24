<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Bill;
use App\Models\Lease;
use App\Models\ActivityLog;
use App\Mail\BillNotification;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::with(['lease.tenant', 'lease.unit']);
        if ($request->filled('status')) { $query->where('status', $request->status); }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('lease.tenant', fn($q) => $q->where('first_name','like',"%{$s}%")->orWhere('last_name','like',"%{$s}%"));
        }
        $bills = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        $leases = Lease::with(['tenant', 'unit'])->where('status', 'active')->get();
        return view('bills.create', compact('leases'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'billing_period_start' => 'required|date',
            'billing_period_end' => 'required|date|after:billing_period_start',
            'rent_amount' => 'required|numeric|min:0',
            'water_amount' => 'required|numeric|min:0',
            'electricity_amount' => 'required|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $v['other_charges'] = $v['other_charges'] ?? 0;
        $v['total_amount'] = $v['rent_amount'] + $v['water_amount'] + $v['electricity_amount'] + $v['other_charges'];
        $v['status'] = 'unpaid';
        $v['created_by'] = auth()->id();
        $bill = Bill::create($v);
        ActivityLog::log('create', "Bill created for lease #{$v['lease_id']}", $bill);
        return redirect()->route('bills.index')->with('success', 'Bill created successfully!');
    }

    public function show(Bill $bill)
    {
        $bill->load(['lease.tenant', 'lease.unit', 'payments', 'creator']);
        return view('bills.show', compact('bill'));
    }

    public function edit(Bill $bill)
    {
        $leases = Lease::with(['tenant', 'unit'])->where('status', 'active')->get();
        return view('bills.edit', compact('bill', 'leases'));
    }

    public function update(Request $request, Bill $bill)
    {
        $v = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'billing_period_start' => 'required|date',
            'billing_period_end' => 'required|date|after:billing_period_start',
            'rent_amount' => 'required|numeric|min:0',
            'water_amount' => 'required|numeric|min:0',
            'electricity_amount' => 'required|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,partial,paid,overdue',
            'notes' => 'nullable|string',
        ]);
        $v['other_charges'] = $v['other_charges'] ?? 0;
        $v['total_amount'] = $v['rent_amount'] + $v['water_amount'] + $v['electricity_amount'] + $v['other_charges'];
        $bill->update($v);
        ActivityLog::log('update', "Bill #{$bill->id} updated", $bill);
        return redirect()->route('bills.index')->with('success', 'Bill updated successfully!');
    }

    public function destroy(Bill $bill)
    {
        if (!auth()->user()->hasPermissionTo('delete-bills')) {
            abort(403, 'You do not have permission to delete bills.');
        }
        $bill->delete();
        ActivityLog::log('delete', "Bill #{$bill->id} deleted");
        return redirect()->route('bills.index')->with('success', 'Bill deleted successfully!');
    }

    public function sendEmail(Bill $bill)
    {
        $bill->load(['lease.tenant', 'lease.unit']);
        $tenant = $bill->lease->tenant;

        if (empty($tenant->email)) {
            return back()->with('error', 'This tenant does not have an email address. Please update their profile first.');
        }

        try {
            Mail::to($tenant->email)->send(new BillNotification($bill));
            ActivityLog::log('email', "Bill #{$bill->id} notification sent to {$tenant->email}", $bill);
            return back()->with('success', "Bill notification sent successfully to {$tenant->email}!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
