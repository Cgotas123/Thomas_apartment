<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use Illuminate\Http\Request;

class UnitTypeController extends Controller
{
    public function index()
    {
        $unitTypes = UnitType::all();
        return view('unit_types.index', compact('unitTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:unit_types',
            'base_rent' => 'required|numeric',
        ]);

        UnitType::create($request->all());
        return back()->with('success', 'Unit type created!');
    }

    public function update(Request $request, UnitType $unitType)
    {
        $request->validate([
            'name' => 'required|string|unique:unit_types,name,' . $unitType->id,
            'base_rent' => 'required|numeric',
        ]);

        $unitType->update($request->all());
        return back()->with('success', 'Unit type updated!');
    }

    public function destroy(UnitType $unitType)
    {
        if ($unitType->units()->count() > 0) {
            return back()->with('error', 'Cannot delete type with existing units.');
        }
        $unitType->delete();
        return back()->with('success', 'Unit type deleted!');
    }
}
