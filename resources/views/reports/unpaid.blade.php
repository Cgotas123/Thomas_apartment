@extends('layouts.app')
@section('title', 'Unpaid Bills Report')
@section('page-title', 'Unpaid Bills Report')
@section('content')
<div class="d-flex justify-content-end mb-3 no-print">
    <a href="{{ route('reports.pdf', 'unpaid') }}" class="btn btn-danger btn-sm me-2"><i class="bi bi-file-pdf me-1"></i>Export PDF</a>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print</button>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="stat-card danger"><div class="stat-icon bg-danger"><i class="bi bi-exclamation-triangle"></i></div><div class="stat-value">₱{{ number_format($totalUnpaid,2) }}</div><div class="stat-label">Total Unpaid</div></div></div>
    <div class="col-md-4"><div class="stat-card warning"><div class="stat-icon bg-warning"><i class="bi bi-receipt"></i></div><div class="stat-value">{{ $bills->count() }}</div><div class="stat-label">Unpaid Bills</div></div></div>
    <div class="col-md-4"><div class="stat-card secondary"><div class="stat-icon bg-secondary"><i class="bi bi-clock"></i></div><div class="stat-value">{{ $overdueCount }}</div><div class="stat-label">Overdue</div></div></div>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>Unit</th><th>Tenant</th><th>Period</th><th>Amount</th><th>Status</th><th>Due Date</th></tr></thead>
    <tbody>
        @foreach($bills as $b)
            <tr><td>{{ $b->lease->unit->unit_number ?? '-' }}</td><td>{{ $b->lease->tenant->full_name ?? '-' }}</td><td>{{ $b->billing_period_start->format('M Y') }}</td><td><strong>₱{{ number_format($b->total_amount,2) }}</strong></td><td>{!! $b->status_badge !!}</td><td>{{ $b->due_date->format('M d, Y') }}</td></tr>
        @endforeach
    </tbody></table>
</div></div></div>
@endsection
