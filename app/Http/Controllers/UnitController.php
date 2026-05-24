<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\ActivityLog;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }
        if ($request->filled('search')) {
            $query->where('unit_number', 'like', '%' . $request->search . '%');
        }

        $units = $query->orderBy('unit_number')->paginate(20);
        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_number' => 'required|string|max:10|unique:units',
            'floor' => 'required|integer|min:1',
            'type' => 'required|in:studio,1br,2br,3br',
            'monthly_rent' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $unit = Unit::create($validated);
        ActivityLog::log('create', "Unit {$unit->unit_number} was created", $unit);

        return redirect()->route('units.index')->with('success', 'Unit created successfully!');
    }

    public function show(Unit $unit)
    {
        $unit->load(['leases.tenant', 'meterReadings', 'maintenanceRequests']);
        return view('units.show', compact('unit'));
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'unit_number' => 'required|string|max:10|unique:units,unit_number,' . $unit->id,
            'floor' => 'required|integer|min:1',
            'type' => 'required|in:studio,1br,2br,3br',
            'monthly_rent' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $unit->update($validated);
        ActivityLog::log('update', "Unit {$unit->unit_number} was updated", $unit);

        return redirect()->route('units.index')->with('success', 'Unit updated successfully!');
    }

    public function destroy(Unit $unit)
    {
        $number = $unit->unit_number;
        $unit->delete();
        ActivityLog::log('delete', "Unit {$number} was deleted");

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully!');
    }
}
