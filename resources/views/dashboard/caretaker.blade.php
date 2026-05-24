@extends('layouts.app')
@section('title', 'Caretaker Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card primary">
            <div class="stat-icon bg-primary"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">{{ $totalTenants }}</div>
            <div class="stat-label">Total Tenants</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card success">
            <div class="stat-icon bg-success"><i class="bi bi-door-open-fill"></i></div>
            <div class="stat-value">{{ $occupiedUnits }}</div>
            <div class="stat-label">Occupied Units</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card warning">
            <div class="stat-icon bg-warning"><i class="bi bi-door-closed-fill"></i></div>
            <div class="stat-value">{{ $vacantUnits }}</div>
            <div class="stat-label">Vacant Units</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card danger">
            <div class="stat-icon bg-danger"><i class="bi bi-wrench-adjustable"></i></div>
            <div class="stat-value">{{ $pendingMaintenance }}</div>
            <div class="stat-label">Pending Maintenance</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header">
                <span><i class="bi bi-graph-up me-2"></i>Monthly Income</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-custom">
            <div class="card-header"><span><i class="bi bi-pie-chart me-2"></i>Occupancy</span></div>
            <div class="card-body">
                <div class="chart-container" style="height:250px">
                    <canvas id="occupancyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-lg-12">
        <div class="card-custom">
            <div class="card-header"><span><i class="bi bi-clock-history me-2"></i>Recent Activities</span></div>
            <div class="card-body" style="max-height:300px;overflow-y:auto">
                @forelse($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-dot {{ $activity->action }}"></div>
                        <div>
                            <div class="activity-text">{{ $activity->description }}</div>
                            <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state"><i class="bi bi-inbox"></i><h5>No recent activities</h5></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('incomeChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthLabels) !!},
            datasets: [{
                label: 'Income (₱)',
                data: {!! json_encode($monthlyIncomeData) !!},
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67,97,238,0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#4361ee'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('occupancyChart'), {
        type: 'doughnut',
        data: {
            labels: ['Occupied', 'Vacant', 'Maintenance'],
            datasets: [{ data: {!! json_encode($occupancyData) !!}, backgroundColor: ['#2dc653','#f4a261','#ef476f'], borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '65%', plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endpush
