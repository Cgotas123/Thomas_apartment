@extends('layouts.app')
@section('title', 'Maintenance Report')
@section('page-title', 'Maintenance Report')
@section('content')
<div class="d-flex justify-content-end mb-3 no-print">
    <a href="{{ route('reports.pdf', 'maintenance') }}" class="btn btn-danger btn-sm me-2"><i class="bi bi-file-pdf me-1"></i>PDF</a>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print</button>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card primary"><div class="stat-icon bg-primary"><i class="bi bi-wrench"></i></div><div class="stat-value">{{ $total }}</div><div class="stat-label">Total Requests</div></div></div>
    <div class="col-md-3"><div class="stat-card warning"><div class="stat-icon bg-warning"><i class="bi bi-clock"></i></div><div class="stat-value">{{ $pending }}</div><div class="stat-label">Pending</div></div></div>
    <div class="col-md-3"><div class="stat-card info"><div class="stat-icon bg-info"><i class="bi bi-gear"></i></div><div class="stat-value">{{ $inProgress }}</div><div class="stat-label">In Progress</div></div></div>
    <div class="col-md-3"><div class="stat-card success"><div class="stat-icon bg-success"><i class="bi bi-check-circle"></i></div><div class="stat-value">{{ $completed }}</div><div class="stat-label">Completed</div></div></div>
</div>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-custom"><div class="card-header">By Priority</div><div class="card-body"><div class="chart-container" style="height:250px"><canvas id="prChart"></canvas></div></div></div>
    </div>
    <div class="col-lg-8">
        <div class="card-custom"><div class="card-header">All Requests</div><div class="card-body p-0"><div class="table-responsive">
            <table class="table-custom"><thead><tr><th>Unit</th><th>Title</th><th>Priority</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($requests as $r)
                    <tr><td>{{ $r->unit->unit_number }}</td><td>{{ $r->title }}</td><td>{!! $r->priority_badge !!}</td><td>{!! $r->status_badge !!}</td><td>{{ $r->created_at->format('M d, Y') }}</td></tr>
                @endforeach
            </tbody></table>
        </div></div></div>
    </div>
</div>
@endsection
@push('scripts')
<script>
new Chart(document.getElementById('prChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($byPriority->keys()->map(fn($k) => ucfirst($k))) !!},
        datasets: [{ data: {!! json_encode($byPriority->values()) !!}, backgroundColor: ['#6c757d','#4cc9f0','#f4a261','#ef476f'], borderRadius: 5 }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
});
</script>
@endpush
