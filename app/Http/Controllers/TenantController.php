<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

use App\Mail\TenantMessageMail;
use Illuminate\Support\Facades\Mail;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['leases' => function($q) {
            $q->where('active', true)->with('unit');
        }])->latest()->get();
        return view('tenants.index', compact('tenants'));
    }

    public function sendMessage(Request $request, Tenant $tenant)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if (!$tenant->email) {
            return back()->with('error', 'Tenant does not have an email address.');
        }

        try {
            Mail::to($tenant->email)->send(new TenantMessageMail(
                $request->subject,
                $request->message,
                $tenant->full_name
            ));
            return back()->with('success', 'Email sent successfully to ' . $tenant->full_name);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $units = Unit::where('status', 'Vacant')->get();
        return view('tenants.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:tenants',
            'phone_number' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:255',
            'category' => 'required|in:Student,Employee,Family',
            'unit_id' => 'required|exists:units,id',
            'monthly_rent' => 'required|numeric',
            'security_deposit' => 'nullable|numeric',
            'advance_payment' => 'nullable|numeric',
            'move_in_date' => 'required|date',
        ]);

        $tenantData = $request->except(['_token', 'unit_id', 'monthly_rent', 'security_deposit', 'advance_payment']);
        $tenantData['registration_date'] = now();
        $tenant = Tenant::create($tenantData);

        // Create Lease automatically
        $lease = Lease::create([
            'unit_id' => $request->unit_id,
            'tenant_id' => $tenant->id,
            'start_date' => $request->move_in_date,
            'monthly_rent' => $request->monthly_rent,
            'security_deposit' => $request->security_deposit ?? 0,
            'active' => true,
        ]);

        // Record the Advance Payment if provided
        if ($request->advance_payment > 0) {
            Payment::create([
                'lease_id' => $lease->id,
                'amount' => $request->advance_payment,
                'payment_date' => now(),
                'type' => 'Rent',
                'method' => 'Cash',
                'reference_no' => 'Advance Payment',
            ]);
        }

        // Update Unit Status
        Unit::find($request->unit_id)->update(['status' => 'Occupied']);

        return redirect()->route('tenants.index')->with('success', 'Tenant registered, Room assigned, and Advance Payment recorded!');
    }

    public function edit(Tenant $tenant)
    {
        $currentLease = Lease::where('tenant_id', $tenant->id)->where('active', true)->first();
        $units = Unit::where('status', 'Vacant')->orWhere('id', $currentLease?->unit_id)->get();
        return view('tenants.edit', compact('tenant', 'units', 'currentLease'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'full_name' => 'required|string',
            'unit_id' => 'required|exists:units,id',
        ]);

        $tenant->update($request->except(['_token', 'unit_id']));

        // Handle Room Change
        $currentLease = Lease::where('tenant_id', $tenant->id)->where('active', true)->first();
        if ($currentLease && $currentLease->unit_id != $request->unit_id) {
            // Vacate old room
            Unit::find($currentLease->unit_id)->update(['status' => 'Vacant']);
            // Update lease
            $currentLease->update(['unit_id' => $request->unit_id]);
            // Occupy new room
            Unit::find($request->unit_id)->update(['status' => 'Occupied']);
        }

        return redirect()->route('tenants.index')->with('success', 'Tenant information updated!');
    }
}
