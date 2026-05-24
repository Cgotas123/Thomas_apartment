@extends('layouts.app')
@section('title', 'Tenants')
@section('page-title', 'Tenants')

@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
    <form class="d-flex gap-2" method="GET">
        <div class="search-bar">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control" name="search" placeholder="Search tenants..." value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
    </form>
    <a href="{{ route('tenants.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Tenant</a>
</div>

<div class="card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#</th><th>Name</th><th>Phone</th><th>Email</th><th>Unit</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->id }}</td>
                            <td><strong>{{ $tenant->full_name }}</strong></td>
                            <td>{{ $tenant->phone }}</td>
                            <td>{{ $tenant->email ?? '-' }}</td>
                            <td>{!! $tenant->activeLease ? '<span class="badge bg-success">Unit ' . $tenant->activeLease->unit->unit_number . '</span>' : '<span class="badge bg-secondary">No Unit</span>' !!}</td>
                            <td>
                                <a href="{{ route('tenants.show', $tenant) }}" class="btn btn-sm btn-outline-primary btn-icon" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-sm btn-outline-primary btn-icon" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form id="delete-{{ $tenant->id }}" action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-{{ $tenant->id }}')" class="btn btn-sm btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty-state"><i class="bi bi-people"></i><h5>No tenants found</h5></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $tenants->withQueryString()->links() }}</div>
@endsection
