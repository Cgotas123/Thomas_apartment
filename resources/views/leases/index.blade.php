@extends('layouts.app')
@section('title', 'Leases')
@section('page-title', 'Leases')
@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
    <form class="d-flex gap-2" method="GET">
        <div class="search-bar"><i class="bi bi-search"></i><input type="text" class="form-control form-control-sm" name="search" placeholder="Search..." value="{{ request('search') }}"></div>
        <select class="form-select form-select-sm" name="status" style="width:auto"><option value="">All Status</option><option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option><option value="expired" {{ request('status')=='expired'?'selected':'' }}>Expired</option><option value="terminated" {{ request('status')=='terminated'?'selected':'' }}>Terminated</option></select>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
    <a href="{{ route('leases.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>New Lease</a>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>Unit</th><th>Tenant</th><th>Period</th><th>Rent</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
        @forelse($leases as $lease)
            <tr>
                <td><strong>{{ $lease->unit->unit_number }}</strong></td>
                <td>{{ $lease->tenant->full_name }}</td>
                <td>{{ $lease->start_date->format('M d, Y') }} - {{ $lease->end_date->format('M d, Y') }}</td>
                <td>₱{{ number_format($lease->monthly_rent, 2) }}</td>
                <td>{!! $lease->status_badge !!}</td>
                <td>
                    <a href="{{ route('leases.show', $lease) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('leases.edit', $lease) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-pencil"></i></a>
                    <form id="del-l-{{ $lease->id }}" action="{{ route('leases.destroy', $lease) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" onclick="confirmDelete('del-l-{{ $lease->id }}')" class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6"><div class="empty-state"><i class="bi bi-file-earmark-text"></i><h5>No leases found</h5></div></td></tr>
        @endforelse
    </tbody></table>
</div></div></div>
<div class="mt-3">{{ $leases->withQueryString()->links() }}</div>
@endsection
