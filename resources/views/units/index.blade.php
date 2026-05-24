@extends('layouts.app')
@section('title', 'Units')
@section('page-title', 'Units')

@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
    <form class="d-flex gap-2 flex-wrap" method="GET">
        <div class="search-bar">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control form-control-sm" name="search" placeholder="Search..." value="{{ request('search') }}">
        </div>
        <select class="form-select form-select-sm" name="status" style="width:auto">
            <option value="">All Status</option>
            <option value="vacant" {{ request('status')=='vacant'?'selected':'' }}>Vacant</option>
            <option value="occupied" {{ request('status')=='occupied'?'selected':'' }}>Occupied</option>
            <option value="maintenance" {{ request('status')=='maintenance'?'selected':'' }}>Maintenance</option>
        </select>
        <select class="form-select form-select-sm" name="type" style="width:auto">
            <option value="">All Types</option>
            <option value="studio" {{ request('type')=='studio'?'selected':'' }}>Studio</option>
            <option value="1br" {{ request('type')=='1br'?'selected':'' }}>1 BR</option>
            <option value="2br" {{ request('type')=='2br'?'selected':'' }}>2 BR</option>
            <option value="3br" {{ request('type')=='3br'?'selected':'' }}>3 BR</option>
        </select>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i> Filter</button>
    </form>
    <a href="{{ route('units.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Unit</a>
</div>

<div class="card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table-custom">
                <thead><tr><th>Unit #</th><th>Floor</th><th>Type</th><th>Rent</th><th>Status</th><th>Tenant</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($units as $unit)
                        <tr>
                            <td><strong>{{ $unit->unit_number }}</strong></td>
                            <td>{{ $unit->floor }}</td>
                            <td>{{ $unit->type_label }}</td>
                            <td>₱{{ number_format($unit->monthly_rent, 2) }}</td>
                            <td>{!! $unit->status_badge !!}</td>
                            <td>{{ $unit->currentTenant()?->full_name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('units.show', $unit) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('units.edit', $unit) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-pencil"></i></a>
                                <form id="del-u-{{ $unit->id }}" action="{{ route('units.destroy', $unit) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('del-u-{{ $unit->id }}')" class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty-state"><i class="bi bi-door-open"></i><h5>No units found</h5></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $units->withQueryString()->links() }}</div>
@endsection
