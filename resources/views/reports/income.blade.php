@extends('layouts.app')
@section('title', 'Income Report')
@section('page-title', 'Income Report')
@section('content')
<div class="filter-bar d-flex flex-wrap justify-content-between align-items-center gap-2 no-print">
    <form class="d-flex gap-2" method="GET">
        <input type="date" class="form-control form-control-sm" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
        <input type="date" class="form-control form-control-sm" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i> Filter</button>
    </form>
    <div>
        <a href="{{ route('reports.pdf', 'income') }}?start_date={{ $startDate->format('Y-m-d') }}&end_date={{ $endDate->format('Y-m-d') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>Export PDF</a>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print</button>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="stat-card success"><div class="stat-icon bg-success"><i class="bi bi-cash-coin"></i></div><div class="stat-value">₱{{ number_format($totalIncome,2) }}</div><div class="stat-label">Total Income</div></div></div>
    <div class="col-md-4"><div class="stat-card primary"><div class="stat-icon bg-primary"><i class="bi bi-receipt"></i></div><div class="stat-value">{{ $payments->count() }}</div><div class="stat-label">Total Payments</div></div></div>
    <div class="col-md-4"><div class="stat-card info"><div class="stat-icon bg-info"><i class="bi bi-calendar"></i></div><div class="stat-value">{{ $startDate->format('M d') }} - {{ $endDate->format('M d') }}</div><div class="stat-label">Period</div></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header">Payment Details</div>
            <div class="card-body p-0"><div class="table-responsive">
                <table class="table-custom"><thead><tr><th>Date</th><th>Unit</th><th>Tenant</th><th>Amount</th><th>Method</th></tr></thead>
                <tbody>
                    @foreach($payments as $p)
                        <tr><td>{{ $p->payment_date->format('M d, Y') }}</td><td>{{ $p->bill->lease->unit->unit_number ?? '-' }}</td><td>{{ $p->bill->lease->tenant->full_name ?? '-' }}</td><td>₱{{ number_format($p->amount,2) }}</td><td>{!! $p->method_badge !!}</td></tr>
                    @endforeach
                </tbody></table>
            </div></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-custom">
            <div class="card-header">By Payment Method</div>
            <div class="card-body">
                <div class="chart-container" style="height:250px"><canvas id="methodChart"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('methodChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($byMethod->keys()->map(fn($k) => ucfirst(str_replace('_',' ',$k)))) !!},
        datasets: [{ data: {!! json_encode($byMethod->values()) !!}, backgroundColor: ['#2dc653','#4361ee','#4cc9f0','#7c3aed'], borderWidth: 0 }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
