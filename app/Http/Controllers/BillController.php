<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Lease;
use App\Models\MeterReading;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with('lease.tenant', 'lease.unit')->latest()->paginate(10);
        return view('bills.index', compact('bills'));
    }

    public function generate(Request $request)
    {
        $leases = Lease::where('active', true)->get();
        $billingDate = Carbon::now();
        $periodStart = Carbon::now()->subMonth();
        $periodEnd = Carbon::now();

        foreach ($leases as $lease) {
            // Get meter readings for this period
            $elecReading = MeterReading::where('unit_id', $lease->unit_id)
                ->where('type', 'Electricity')
                ->where('status', 'Posted')
                ->whereBetween('reading_date', [$periodStart, $periodEnd])
                ->sum('cost');

            $waterReading = MeterReading::where('unit_id', $lease->unit_id)
                ->where('type', 'Water')
                ->where('status', 'Posted')
                ->whereBetween('reading_date', [$periodStart, $periodEnd])
                ->sum('cost');

            $wifiFee = Setting::where('key', 'wifi_monthly_fee')->value('value') ?? 500;

            $total = $lease->monthly_rent + $elecReading + $waterReading + $wifiFee;

            Bill::create([
                'lease_id' => $lease->id,
                'billing_date' => $billingDate,
                'due_date' => $billingDate->copy()->addDays(7),
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'rent_amount' => $lease->monthly_rent,
                'electricity_amount' => $elecReading,
                'water_amount' => $waterReading,
                'wifi_fee' => $wifiFee,
                'total_amount' => $total,
                'status' => 'Unpaid'
            ]);
        }

        return redirect()->route('bills.index')->with('success', 'Monthly bills generated successfully!');
    }

    public function show(Bill $bill)
    {
        return view('bills.show', compact('bill'));
    }
}
