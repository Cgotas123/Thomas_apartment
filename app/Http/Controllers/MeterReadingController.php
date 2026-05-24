<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeterReading;
use App\Models\Unit;
use App\Models\ActivityLog;

class MeterReadingController extends Controller
{
    public function index(Request $request)
    {
        $query = MeterReading::with(['unit', 'recorder']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }
        if ($request->filled('month')) {
            $query->whereMonth('reading_date', date('m', strtotime($request->month)))
                  ->whereYear('reading_date', date('Y', strtotime($request->month)));
        }

        $readings = $query->orderBy('reading_date', 'desc')->paginate(20);
        $units = Unit::where('status', 'occupied')->orderBy('unit_number')->get();
        return view('meter-readings.index', compact('readings', 'units'));
    }

    public function create()
    {
        $units = Unit::where('status', 'occupied')->orderBy('unit_number')->get();
        return view('meter-readings.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|in:water,electricity',
            'previous_reading' => 'required|numeric|min:0',
            'current_reading' => 'required|numeric|min:0|gte:previous_reading',
            'rate_per_unit' => 'required|numeric|min:0',
            'reading_date' => 'required|date',
        ]);

        $validated['consumption'] = $validated['current_reading'] - $validated['previous_reading'];
        $validated['recorded_by'] = auth()->id();

        $reading = MeterReading::create($validated);
        $unit = Unit::find($validated['unit_id']);
        ActivityLog::log('create', "Meter reading ({$validated['type']}) recorded for Unit {$unit->unit_number}", $reading);

        return redirect()->route('meter-readings.index')->with('success', 'Meter reading recorded successfully!');
    }

    public function show(MeterReading $meterReading)
    {
        $meterReading->load(['unit', 'recorder']);
        return view('meter-readings.show', compact('meterReading'));
    }

    public function edit(MeterReading $meterReading)
    {
        $units = Unit::where('status', 'occupied')->orderBy('unit_number')->get();
        return view('meter-readings.edit', compact('meterReading', 'units'));
    }

    public function update(Request $request, MeterReading $meterReading)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|in:water,electricity',
            'previous_reading' => 'required|numeric|min:0',
            'current_reading' => 'required|numeric|min:0|gte:previous_reading',
            'rate_per_unit' => 'required|numeric|min:0',
            'reading_date' => 'required|date',
        ]);

        $validated['consumption'] = $validated['current_reading'] - $validated['previous_reading'];

        $meterReading->update($validated);
        ActivityLog::log('update', "Meter reading updated for Unit {$meterReading->unit->unit_number}", $meterReading);

        return redirect()->route('meter-readings.index')->with('success', 'Meter reading updated successfully!');
    }

    public function destroy(MeterReading $meterReading)
    {
        $unitNumber = $meterReading->unit->unit_number;
        $meterReading->delete();
        ActivityLog::log('delete', "Meter reading deleted for Unit {$unitNumber}");

        return redirect()->route('meter-readings.index')->with('success', 'Meter reading deleted successfully!');
    }
}
