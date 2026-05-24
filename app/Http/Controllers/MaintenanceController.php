<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Unit;
use App\Models\ActivityLog;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['unit', 'reporter']);
        if ($request->filled('status')) { $query->where('status', $request->status); }
        if ($request->filled('priority')) { $query->where('priority', $request->priority); }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('title', 'like', "%{$s}%")
                ->orWhereHas('unit', fn($q) => $q->where('unit_number', 'like', "%{$s}%"));
        }
        $requests = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('maintenance.index', compact('requests'));
    }

    public function create()
    {
        $units = Unit::orderBy('unit_number')->get();
        return view('maintenance.create', compact('units'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);
        $v['status'] = 'pending';
        $v['reported_by'] = auth()->id();
        $mr = MaintenanceRequest::create($v);
        ActivityLog::log('create', "Maintenance request: {$v['title']} for Unit " . Unit::find($v['unit_id'])->unit_number, $mr);
        return redirect()->route('maintenance.index')->with('success', 'Maintenance request created!');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        $maintenance->load(['unit', 'reporter']);
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        $units = Unit::orderBy('unit_number')->get();
        return view('maintenance.edit', compact('maintenance', 'units'));
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $v = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'completion_notes' => 'nullable|string',
        ]);
        if ($v['status'] === 'completed' && $maintenance->status !== 'completed') {
            $v['completed_at'] = now();
        }
        $maintenance->update($v);
        ActivityLog::log('update', "Maintenance request #{$maintenance->id} updated to {$v['status']}", $maintenance);
        return redirect()->route('maintenance.index')->with('success', 'Maintenance request updated!');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        $maintenance->delete();
        ActivityLog::log('delete', "Maintenance request #{$maintenance->id} deleted");
        return redirect()->route('maintenance.index')->with('success', 'Maintenance request deleted!');
    }
}
