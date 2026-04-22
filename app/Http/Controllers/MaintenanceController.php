<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with(['unit', 'tenant', 'assignedTo'])->latest()->get();
        return view('maintenance.index', compact('requests'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('maintenance.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High,Urgent',
        ]);

        MaintenanceRequest::create($request->except('_token'));

        return redirect()->route('maintenance.index')->with('success', 'Maintenance request submitted!');
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $request->validate([
            'status' => 'required|in:Pending,Assigned,In Progress,Completed,Canceled',
        ]);

        $maintenance->update([
            'status' => $request->status,
            'completed_at' => ($request->status == 'Completed') ? now() : $maintenance->completed_at,
        ]);

        return redirect()->back()->with('success', 'Status updated!');
    }
}
