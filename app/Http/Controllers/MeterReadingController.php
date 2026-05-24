<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use App\Models\Unit;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    public function index()
    {
        $readings = MeterReading::with('unit')->latest()->get();
        return view('meter_readings.index', compact('readings'));
    }

    public function bulkCreate()
    {
        $units = Unit::all();
        return view('meter_readings.bulk', compact('units'));
    }

    public function create()
    {
        return redirect()->route('meter_readings.bulk');
    }

    public function bulkStore(Request $request)
    {
        $readings = $request->input('readings');
        $date = $request->input('reading_date');

        foreach ($readings as $id_key => $data) {
            // Extract the actual numeric unit_id from the key (e.g., "1_w" becomes 1)
            $unit_id = (int) $id_key; 
            
            if (isset($data['current']) && $data['current'] !== null) {
                $prev = $data['previous'] ?? 0;
                $curr = $data['current'];
                $consumption = $curr - $prev;
                
                $cost = \App\Models\MeterReading::calculateCost($data['type'], $consumption);

                \App\Models\MeterReading::create([
                    'unit_id' => $unit_id,
                    'type' => $data['type'],
                    'previous_reading' => $prev,
                    'current_reading' => $curr,
                    'consumption' => $consumption,
                    'cost' => $cost,
                    'reading_date' => $date,
                    'status' => 'Draft'
                ]);
            }
        }

        return redirect()->route('meter_readings.index')->with('success', 'All readings saved as Draft!');
    }

    public function post(MeterReading $meterReading)
    {
        $meterReading->update(['status' => 'Posted']);
        return back()->with('success', 'Meter reading posted successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|in:Water,Electricity',
            'previous_reading' => 'required|numeric',
            'current_reading' => 'required|numeric|gte:previous_reading',
            'reading_date' => 'required|date',
        ]);

        $consumption = $request->current_reading - $request->previous_reading;
        $cost = \App\Models\MeterReading::calculateCost($request->type, $consumption);

        MeterReading::create([
            'unit_id' => $request->unit_id,
            'type' => $request->type,
            'previous_reading' => $request->previous_reading,
            'current_reading' => $request->current_reading,
            'consumption' => $consumption,
            'cost' => $cost,
            'reading_date' => $request->reading_date,
        ]);

        return redirect()->route('meter_readings.index')->with('success', 'Reading recorded! Calculated Cost: ₱' . number_format($cost, 2));
    }

    public function edit(MeterReading $meterReading)
    {
        $units = Unit::all();
        return view('meter_readings.edit', compact('meterReading', 'units'));
    }

    public function update(Request $request, MeterReading $meterReading)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|in:Water,Electricity',
            'previous_reading' => 'required|numeric',
            'current_reading' => 'required|numeric|gte:previous_reading',
            'reading_date' => 'required|date',
        ]);

        $consumption = $request->current_reading - $request->previous_reading;
        $cost = \App\Models\MeterReading::calculateCost($request->type, $consumption);

        $meterReading->update([
            'unit_id' => $request->unit_id,
            'type' => $request->type,
            'previous_reading' => $request->previous_reading,
            'current_reading' => $request->current_reading,
            'consumption' => $consumption,
            'cost' => $cost,
            'reading_date' => $request->reading_date,
        ]);

        return redirect()->route('meter_readings.index')->with('success', 'Reading updated and cost recalculated!');
    }

    public function destroy(MeterReading $meterReading)
    {
        $meterReading->delete();
        return redirect()->route('meter_readings.index')->with('success', 'Reading deleted successfully!');
    }
}
