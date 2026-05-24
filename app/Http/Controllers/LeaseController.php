<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\ActivityLog;

class LeaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Lease::with(['tenant', 'unit']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('tenant', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhereHas('unit', function ($q) use ($search) {
                $q->where('unit_number', 'like', "%{$search}%");
            });
        }

        $leases = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('leases.index', compact('leases'));
    }

    public function create()
    {
        $tenants = Tenant::orderBy('first_name')->get();
        $units = Unit::where('status', 'vacant')->orderBy('unit_number')->get();
        return view('leases.create', compact('tenants', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'status' => 'required|in:active,expired,terminated',
            'notes' => 'nullable|string',
        ]);

        $lease = Lease::create($validated);

        // Update unit status if lease is active
        if ($validated['status'] === 'active') {
            Unit::where('id', $validated['unit_id'])->update(['status' => 'occupied']);
        }

        ActivityLog::log('create', "Lease created for Unit {$lease->unit->unit_number}", $lease);

        return redirect()->route('leases.index')->with('success', 'Lease created successfully!');
    }

    public function show(Lease $lease)
    {
        $lease->load(['tenant', 'unit', 'bills.payments']);
        return view('leases.show', compact('lease'));
    }

    public function edit(Lease $lease)
    {
        $tenants = Tenant::orderBy('first_name')->get();
        $units = Unit::where('status', 'vacant')
            ->orWhere('id', $lease->unit_id)
            ->orderBy('unit_number')
            ->get();
        return view('leases.edit', compact('lease', 'tenants', 'units'));
    }

    public function update(Request $request, Lease $lease)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'status' => 'required|in:active,expired,terminated',
            'notes' => 'nullable|string',
        ]);

        // Handle unit status changes
        if ($lease->unit_id != $validated['unit_id']) {
            Unit::where('id', $lease->unit_id)->update(['status' => 'vacant']);
        }

        if ($validated['status'] === 'active') {
            Unit::where('id', $validated['unit_id'])->update(['status' => 'occupied']);
        } elseif (in_array($validated['status'], ['expired', 'terminated'])) {
            Unit::where('id', $validated['unit_id'])->update(['status' => 'vacant']);
        }

        $lease->update($validated);
        ActivityLog::log('update', "Lease for Unit {$lease->unit->unit_number} was updated", $lease);

        return redirect()->route('leases.index')->with('success', 'Lease updated successfully!');
    }

    public function destroy(Lease $lease)
    {
        $unitNumber = $lease->unit->unit_number;
        Unit::where('id', $lease->unit_id)->update(['status' => 'vacant']);
        $lease->delete();
        ActivityLog::log('delete', "Lease for Unit {$unitNumber} was deleted");

        return redirect()->route('leases.index')->with('success', 'Lease deleted successfully!');
    }
}
