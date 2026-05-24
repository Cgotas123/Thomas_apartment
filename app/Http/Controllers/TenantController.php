<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\ActivityLog;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $tenants = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'id_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $tenant = Tenant::create($validated);
        ActivityLog::log('create', "New tenant {$tenant->full_name} was registered", $tenant);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully!');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['leases.unit', 'leases.bills.payments']);
        return view('tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'id_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $tenant->update($validated);
        ActivityLog::log('update', "Tenant {$tenant->full_name} was updated", $tenant);

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully!');
    }

    public function destroy(Tenant $tenant)
    {
        $name = $tenant->full_name;
        $tenant->delete();
        ActivityLog::log('delete', "Tenant {$name} was deleted");

        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully!');
    }
}
