<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Bill;
use App\Models\ActivityLog;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['bill.lease.tenant', 'bill.lease.unit', 'receiver']);
        if ($request->filled('method')) { $query->where('payment_method', $request->method); }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('reference_number', 'like', "%{$s}%")
                ->orWhereHas('bill.lease.tenant', fn($q) => $q->where('first_name','like',"%{$s}%")->orWhere('last_name','like',"%{$s}%"));
        }
        $payments = $query->orderBy('payment_date', 'desc')->paginate(15);
        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $bills = Bill::with(['lease.tenant', 'lease.unit'])->whereIn('status', ['unpaid', 'partial', 'overdue'])->get();
        $selectedBill = $request->bill_id ? Bill::find($request->bill_id) : null;
        return view('payments.create', compact('bills', 'selectedBill'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,gcash,maya',
            'reference_number' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $v['received_by'] = auth()->id();
        $payment = Payment::create($v);

        // Update bill status
        $bill = Bill::find($v['bill_id']);
        $totalPaid = $bill->payments->sum('amount');
        if ($totalPaid >= $bill->total_amount) {
            $bill->update(['status' => 'paid']);
        } else {
            $bill->update(['status' => 'partial']);
        }

        ActivityLog::log('create', "Payment of ₱" . number_format($v['amount'], 2) . " received for Bill #{$v['bill_id']}", $payment);
        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['bill.lease.tenant', 'bill.lease.unit', 'receiver']);
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        if (!auth()->user()->hasRole('admin')) { abort(403); }
        $payment->delete();
        ActivityLog::log('delete', "Payment #{$payment->id} deleted");
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully!');
    }
}
