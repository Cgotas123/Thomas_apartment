@extends('layouts.app')
@section('title', 'Occupancy Report')
@section('page-title', 'Occupancy Report')
@section('content')
<div class="d-flex justify-content-end mb-3 no-print">
    <a href="{{ route('reports.pdf', 'occupancy') }}" class="btn btn-danger btn-sm me-2"><i class="bi bi-file-pdf me-1"></i>Export PDF</a>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print</button>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card primary"><div class="stat-icon bg-primary"><i class="bi bi-building"></i></div><div class="stat-value">{{ $total }}</div><div class="stat-label">Total Units</div></div></div>
    <div class="col-md-3"><div class="stat-card success"><div class="stat-icon bg-success"><i class="bi bi-check-circle"></i></div><div class="stat-value">{{ $occupied }}</div><div class="stat-label">Occupied</div></div></div>
    <div class="col-md-3"><div class="stat-card warning"><div class="stat-icon bg-warning"><i class="bi bi-dash-circle"></i></div><div class="stat-value">{{ $vacant }}</div><div class="stat-label">Vacant</div></div></div>
    <div class="col-md-3"><div class="stat-card info"><div class="stat-icon bg-info"><i class="bi bi-percent"></i></div><div class="stat-value">{{ $rate }}%</div><div class="stat-label">Occupancy Rate</div></div></div>
</div>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-custom"><div class="card-header">Occupancy Chart</div><div class="card-body"><div class="chart-container" style="height:250px"><canvas id="occChart"></canvas></div></div></div>
    </div>
    <div class="col-lg-8">
        <div class="card-custom"><div class="card-header">Unit Details</div><div class="card-body p-0"><div class="table-responsive">
            <table class="table-custom"><thead><tr><th>Unit</th><th>Floor</th><th>Type</th><th>Rent</th><th>Status</th><th>Tenant</th></tr></thead>
            <tbody>
                @foreach($units as $u)
                    <tr><td>{{ $u->unit_number }}</td><td>{{ $u->floor }}</td><td>{{ $u->type_label }}</td><td>₱{{ number_format($u->monthly_rent,2) }}</td><td>{!! $u->status_badge !!}</td><td>{{ $u->activeLease?->tenant?->full_name ?? '-' }}</td></tr>
                @endforeach
            </tbody></table>
        </div></div></div>
    </div>
</div>
@endsection
@push('scripts')
<script>
new Chart(document.getElementById('occChart'), {
    type: 'doughnut',
    data: { labels: ['Occupied','Vacant','Maintenance'], datasets: [{ data: [{{ $occupied }},{{ $vacant }},{{ $maintenance }}], backgroundColor: ['#2dc653','#f4a261','#ef476f'], borderWidth: 0 }] },
    options: { responsive: true, maintainAspectRatio: false, cutout: '60%', plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
