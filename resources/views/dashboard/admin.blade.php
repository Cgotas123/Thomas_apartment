@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card primary">
            <div class="stat-icon bg-primary"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">{{ $totalTenants }}</div>
            <div class="stat-label">Total Tenants</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card success">
            <div class="stat-icon bg-success"><i class="bi bi-door-open-fill"></i></div>
            <div class="stat-value">{{ $occupiedUnits }}</div>
            <div class="stat-label">Occupied Units</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card warning">
            <div class="stat-icon bg-warning"><i class="bi bi-door-closed-fill"></i></div>
            <div class="stat-value">{{ $vacantUnits }}</div>
            <div class="stat-label">Vacant Units</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card info">
            <div class="stat-icon bg-info"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-value">₱{{ number_format($monthlyIncome) }}</div>
            <div class="stat-label">Monthly Income</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card danger">
            <div class="stat-icon bg-danger"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="stat-value">₱{{ number_format($unpaidBills) }}</div>
            <div class="stat-label">Unpaid Bills ({{ $unpaidBillsCount }})</div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card secondary">
            <div class="stat-icon bg-secondary"><i class="bi bi-wrench-adjustable"></i></div>
            <div class="stat-value">{{ $pendingMaintenance }}</div>
            <div class="stat-label">Pending Maintenance</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="card-header">
                <span><i class="bi bi-graph-up me-2"></i>Monthly Income (Last 6 Months)</span>
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
            <div class="card-header">
                <span><i class="bi bi-pie-chart me-2"></i>Occupancy</span>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height:250px">
                    <canvas id="occupancyChart"></canvas>
                </div>
                <div class="text-center mt-2">
                    <small class="text-muted">{{ $occupiedUnits + $vacantUnits + $maintenanceUnits }} Total Units</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card-custom">
            <div class="card-header">
                <span><i class="bi bi-clock-history me-2"></i>Recent Activities</span>
            </div>
            <div class="card-body" style="max-height:350px;overflow-y:auto">
                @forelse($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-dot {{ $activity->action }}"></div>
                        <div>
                            <div class="activity-text">{{ $activity->description }}</div>
                            <div class="activity-time">
                                {{ $activity->user->name ?? 'System' }} · {{ $activity->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h5>No recent activities</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-custom">
            <div class="card-header">
                <span><i class="bi bi-exclamation-circle me-2"></i>Unpaid Bills</span>
                <a href="{{ route('bills.index') }}?status=unpaid" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" style="max-height:350px;overflow-y:auto">
                @forelse($recentUnpaidBills as $bill)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <strong>Unit {{ $bill->lease->unit->unit_number ?? 'N/A' }}</strong>
                            <br><small class="text-muted">{{ $bill->lease->tenant->full_name ?? 'N/A' }}</small>
                        </div>
                        <div class="text-end">
                            <strong class="text-danger">₱{{ number_format($bill->total_amount, 2) }}</strong>
                            <br><small class="text-muted">Due: {{ $bill->due_date->format('M d, Y') }}</small>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-check-circle"></i>
                        <h5>All bills are paid!</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Income Chart
    new Chart(document.getElementById('incomeChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthLabels) !!},
            datasets: [{
                label: 'Income (₱)',
                data: {!! json_encode($monthlyIncomeData) !!},
                backgroundColor: 'rgba(67, 97, 238, 0.8)',
                borderColor: '#4361ee',
                borderWidth: 2,
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => '₱' + v.toLocaleString() } }
            }
        }
    });

    // Occupancy Chart
    new Chart(document.getElementById('occupancyChart'), {
        type: 'doughnut',
        data: {
            labels: ['Occupied', 'Vacant', 'Maintenance'],
            datasets: [{
                data: {!! json_encode($occupancyData) !!},
                backgroundColor: ['#2dc653', '#f4a261', '#ef476f'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true } } }
        }
    });
</script>
@endpush
