<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Lease;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('lease.tenant', 'lease.unit');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('lease.tenant', function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%");
            })->orWhereHas('lease.unit', function($q) use ($search) {
                $q->where('unit_number', 'like', "%{$search}%");
            })->orWhere('reference_no', 'like', "%{$search}%")
              ->orWhere('payment_date', 'like', "%{$search}%");
        }

        $payments = $query->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $leases = Lease::with(['tenant', 'unit'])->where('active', true)->get();
        
        // Calculate pending balances for each lease
        foreach ($leases as $lease) {
            $latestElec = \App\Models\MeterReading::where('unit_id', $lease->unit_id)->where('type', 'Electricity')->latest()->first();
            $latestWater = \App\Models\MeterReading::where('unit_id', $lease->unit_id)->where('type', 'Water')->latest()->first();
            
            $lease->pending_utilities = ($latestElec ? $latestElec->cost : 0) + ($latestWater ? $latestWater->cost : 0);
            $lease->total_due = $lease->monthly_rent + $lease->pending_utilities + $lease->wifi_fee;
        }

        return view('payments.create', compact('leases'));
    }

    public function edit(Payment $payment)
    {
        $leases = Lease::with(['tenant', 'unit'])->get();
        return view('payments.edit', compact('payment', 'leases'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'type' => 'required',
            'method' => 'required',
        ]);

        $payment->update($request->except('_token'));
        return redirect()->route('payments.index')->with('success', 'Payment updated!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted!');
    }
}
