@extends('layouts.app')
@section('title', 'Unit Details')
@section('page-title', 'Unit ' . $unit->unit_number)
@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card-custom">
            <div class="card-body text-center">
                <div class="stat-icon bg-primary mx-auto mb-3" style="width:60px;height:60px;font-size:1.5rem"><i class="bi bi-door-open"></i></div>
                <h4>Unit {{ $unit->unit_number }}</h4>
                <p>{!! $unit->status_badge !!}</p>
                <hr>
                <p><strong>Floor:</strong> {{ $unit->floor }}</p>
                <p><strong>Type:</strong> {{ $unit->type_label }}</p>
                <p><strong>Rent:</strong> ₱{{ number_format($unit->monthly_rent, 2) }}</p>
                <p><strong>Tenant:</strong> {{ $unit->currentTenant()?->full_name ?? 'No tenant' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header">Maintenance Requests</div>
            <div class="card-body p-0">
                <table class="table-custom"><thead><tr><th>Title</th><th>Priority</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    @forelse($unit->maintenanceRequests->take(5) as $mr)
                        <tr><td>{{ $mr->title }}</td><td>{!! $mr->priority_badge !!}</td><td>{!! $mr->status_badge !!}</td><td>{{ $mr->created_at->format('M d, Y') }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-3">No requests</td></tr>
                    @endforelse
                </tbody></table>
            </div>
        </div>
    </div>
</div>
<div class="mt-3"><a href="{{ route('units.edit', $unit) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a> <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Back</a></div>
@endsection
