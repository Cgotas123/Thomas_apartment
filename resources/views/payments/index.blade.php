@extends('layouts.app')
@section('title', 'Payments')
@section('page-title', 'Payments')
@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
    <form class="d-flex gap-2" method="GET">
        <div class="search-bar"><i class="bi bi-search"></i><input type="text" class="form-control form-control-sm" name="search" placeholder="Search..." value="{{ request('search') }}"></div>
        <select class="form-select form-select-sm" name="method" style="width:auto"><option value="">All Methods</option><option value="cash" {{ request('method')=='cash'?'selected':'' }}>Cash</option><option value="bank_transfer" {{ request('method')=='bank_transfer'?'selected':'' }}>Bank Transfer</option><option value="gcash" {{ request('method')=='gcash'?'selected':'' }}>GCash</option><option value="maya" {{ request('method')=='maya'?'selected':'' }}>Maya</option></select>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
    <a href="{{ route('payments.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Record Payment</a>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>#</th><th>Unit</th><th>Tenant</th><th>Amount</th><th>Method</th><th>Reference</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
        @forelse($payments as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->bill->lease->unit->unit_number ?? 'N/A' }}</td>
                <td>{{ $p->bill->lease->tenant->full_name ?? 'N/A' }}</td>
                <td><strong>₱{{ number_format($p->amount,2) }}</strong></td>
                <td>{!! $p->method_badge !!}</td>
                <td>{{ $p->reference_number ?? '-' }}</td>
                <td>{{ $p->payment_date->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('payments.show', $p) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-eye"></i></a>
                    @role('admin')<form id="del-p-{{ $p->id }}" action="{{ route('payments.destroy', $p) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" onclick="confirmDelete('del-p-{{ $p->id }}')" class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></button></form>@endrole
                </td>
            </tr>
        @empty
            <tr><td colspan="8"><div class="empty-state"><i class="bi bi-cash-stack"></i><h5>No payments found</h5></div></td></tr>
        @endforelse
    </tbody></table>
</div></div></div>
<div class="mt-3">{{ $payments->withQueryString()->links() }}</div>
@endsection
