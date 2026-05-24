@extends('layouts.app')
@section('title', 'Meter Readings')
@section('page-title', 'Meter Readings')
@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
    <form class="d-flex gap-2 flex-wrap" method="GET">
        <select class="form-select form-select-sm" name="type" style="width:auto"><option value="">All Types</option><option value="water" {{ request('type')=='water'?'selected':'' }}>Water</option><option value="electricity" {{ request('type')=='electricity'?'selected':'' }}>Electricity</option></select>
        <select class="form-select form-select-sm" name="unit_id" style="width:auto"><option value="">All Units</option>@foreach($units as $u)<option value="{{ $u->id }}" {{ request('unit_id')==$u->id?'selected':'' }}>{{ $u->unit_number }}</option>@endforeach</select>
        <input type="month" class="form-control form-control-sm" name="month" value="{{ request('month') }}" style="width:auto">
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
    <a href="{{ route('meter-readings.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Record Reading</a>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>Unit</th><th>Type</th><th>Previous</th><th>Current</th><th>Consumption</th><th>Rate</th><th>Amount</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
        @forelse($readings as $r)
            <tr>
                <td><strong>{{ $r->unit->unit_number }}</strong></td>
                <td>{!! $r->type_badge !!}</td>
                <td>{{ number_format($r->previous_reading,2) }}</td>
                <td>{{ number_format($r->current_reading,2) }}</td>
                <td>{{ number_format($r->consumption,2) }}</td>
                <td>₱{{ number_format($r->rate_per_unit,2) }}</td>
                <td><strong>₱{{ number_format($r->total_amount,2) }}</strong></td>
                <td>{{ $r->reading_date->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('meter-readings.edit', $r) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-pencil"></i></a>
                    <form id="del-mr-{{ $r->id }}" action="{{ route('meter-readings.destroy', $r) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" onclick="confirmDelete('del-mr-{{ $r->id }}')" class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="9"><div class="empty-state"><i class="bi bi-speedometer"></i><h5>No readings found</h5></div></td></tr>
        @endforelse
    </tbody></table>
</div></div></div>
<div class="mt-3">{{ $readings->withQueryString()->links() }}</div>
@endsection
