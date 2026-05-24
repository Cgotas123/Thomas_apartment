@extends('layouts.app')
@section('title', 'Maintenance Requests')
@section('page-title', 'Maintenance Requests')
@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
    <form class="d-flex gap-2 flex-wrap" method="GET">
        <div class="search-bar"><i class="bi bi-search"></i><input type="text" class="form-control form-control-sm" name="search" placeholder="Search..." value="{{ request('search') }}"></div>
        <select class="form-select form-select-sm" name="status" style="width:auto"><option value="">All Status</option><option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option><option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>In Progress</option><option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option><option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option></select>
        <select class="form-select form-select-sm" name="priority" style="width:auto"><option value="">All Priority</option><option value="low" {{ request('priority')=='low'?'selected':'' }}>Low</option><option value="medium" {{ request('priority')=='medium'?'selected':'' }}>Medium</option><option value="high" {{ request('priority')=='high'?'selected':'' }}>High</option><option value="urgent" {{ request('priority')=='urgent'?'selected':'' }}>Urgent</option></select>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
    <a href="{{ route('maintenance.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>New Request</a>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>Unit</th><th>Title</th><th>Priority</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
        @forelse($requests as $r)
            <tr>
                <td><strong>{{ $r->unit->unit_number }}</strong></td>
                <td>{{ $r->title }}</td>
                <td>{!! $r->priority_badge !!}</td>
                <td>{!! $r->status_badge !!}</td>
                <td>{{ $r->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('maintenance.show', $r) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('maintenance.edit', $r) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-pencil"></i></a>
                    <form id="del-m-{{ $r->id }}" action="{{ route('maintenance.destroy', $r) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" onclick="confirmDelete('del-m-{{ $r->id }}')" class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6"><div class="empty-state"><i class="bi bi-wrench"></i><h5>No maintenance requests</h5></div></td></tr>
        @endforelse
    </tbody></table>
</div></div></div>
<div class="mt-3">{{ $requests->withQueryString()->links() }}</div>
@endsection
