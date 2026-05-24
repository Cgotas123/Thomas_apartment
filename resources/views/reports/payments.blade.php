@extends('layouts.app')
@section('title', 'Payment History Report')
@section('page-title', 'Payment History Report')
@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2 no-print">
    <form class="d-flex gap-2" method="GET">
        <input type="date" class="form-control form-control-sm" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
        <input type="date" class="form-control form-control-sm" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i> Filter</button>
    </form>
    <div>
        <a href="{{ route('reports.pdf', 'payments') }}?start_date={{ $startDate->format('Y-m-d') }}&end_date={{ $endDate->format('Y-m-d') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>PDF</a>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print</button>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-6"><div class="stat-card success"><div class="stat-icon bg-success"><i class="bi bi-cash"></i></div><div class="stat-value">₱{{ number_format($totalAmount,2) }}</div><div class="stat-label">Total Payments</div></div></div>
    <div class="col-md-6"><div class="stat-card primary"><div class="stat-icon bg-primary"><i class="bi bi-receipt"></i></div><div class="stat-value">{{ $payments->count() }}</div><div class="stat-label">Transaction Count</div></div></div>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>Date</th><th>Unit</th><th>Tenant</th><th>Amount</th><th>Method</th><th>Reference</th></tr></thead>
    <tbody>
        @foreach($payments as $p)
            <tr><td>{{ $p->payment_date->format('M d, Y') }}</td><td>{{ $p->bill->lease->unit->unit_number ?? '-' }}</td><td>{{ $p->bill->lease->tenant->full_name ?? '-' }}</td><td>₱{{ number_format($p->amount,2) }}</td><td>{!! $p->method_badge !!}</td><td>{{ $p->reference_number ?? '-' }}</td></tr>
        @endforeach
    </tbody></table>
</div></div></div>
@endsection
