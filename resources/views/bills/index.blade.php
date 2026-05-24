@extends('layouts.app')
@section('title', 'Bills')
@section('page-title', 'Bills')
@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
    <form class="d-flex gap-2 flex-wrap" method="GET">
        <div class="search-bar"><i class="bi bi-search"></i><input type="text" class="form-control form-control-sm" name="search" placeholder="Search..." value="{{ request('search') }}"></div>
        <select class="form-select form-select-sm" name="status" style="width:auto"><option value="">All Status</option><option value="unpaid" {{ request('status')=='unpaid'?'selected':'' }}>Unpaid</option><option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option><option value="partial" {{ request('status')=='partial'?'selected':'' }}>Partial</option><option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>Overdue</option></select>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
    <a href="{{ route('bills.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>New Bill</a>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>#</th><th>Unit</th><th>Tenant</th><th>Period</th><th>Total</th><th>Status</th><th>Due</th><th>Actions</th></tr></thead>
    <tbody>
        @forelse($bills as $bill)
            <tr>
                <td>{{ $bill->id }}</td>
                <td><strong>{{ $bill->lease->unit->unit_number ?? 'N/A' }}</strong></td>
                <td>{{ $bill->lease->tenant->full_name ?? 'N/A' }}</td>
                <td>{{ $bill->billing_period_start->format('M Y') }}</td>
                <td><strong>₱{{ number_format($bill->total_amount,2) }}</strong></td>
                <td>{!! $bill->status_badge !!}</td>
                <td>{{ $bill->due_date->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('bills.show', $bill) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('bills.edit', $bill) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-pencil"></i></a>
                    @if($bill->status !== 'paid')<a href="{{ route('payments.create') }}?bill_id={{ $bill->id }}" class="btn btn-sm btn-success btn-icon" title="Record Payment"><i class="bi bi-cash"></i></a>@endif
                    @if($bill->lease->tenant->email)<form action="{{ route('bills.send-email', $bill) }}" method="POST" class="d-inline" onsubmit="return confirm('Send bill to {{ $bill->lease->tenant->email }}?');"><span>@csrf</span><button type="submit" class="btn btn-sm btn-info btn-icon text-white" title="Send via Email"><i class="bi bi-envelope"></i></button></form>@endif
                    @can('delete-bills')<form id="del-b-{{ $bill->id }}" action="{{ route('bills.destroy', $bill) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" onclick="confirmDelete('del-b-{{ $bill->id }}')" class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></button></form>@endcan
                </td>
            </tr>
        @empty
            <tr><td colspan="8"><div class="empty-state"><i class="bi bi-receipt"></i><h5>No bills found</h5></div></td></tr>
        @endforelse
    </tbody></table>
</div></div></div>
<div class="mt-3">{{ $bills->withQueryString()->links() }}</div>
@endsection
