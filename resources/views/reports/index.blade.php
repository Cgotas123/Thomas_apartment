@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports')
@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('reports.income') }}" class="report-card">
            <div class="report-icon bg-success"><i class="bi bi-cash-coin"></i></div>
            <h5>Monthly Income</h5>
            <p class="text-muted mb-0">View income reports with date filtering</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('reports.unpaid') }}" class="report-card">
            <div class="report-icon bg-danger"><i class="bi bi-exclamation-triangle"></i></div>
            <h5>Unpaid Bills</h5>
            <p class="text-muted mb-0">Track unpaid and overdue bills</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('reports.occupancy') }}" class="report-card">
            <div class="report-icon bg-primary"><i class="bi bi-building"></i></div>
            <h5>Occupancy</h5>
            <p class="text-muted mb-0">Unit occupancy rates and status</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('reports.payments') }}" class="report-card">
            <div class="report-icon" style="background:var(--info)"><i class="bi bi-credit-card"></i></div>
            <h5>Payment History</h5>
            <p class="text-muted mb-0">Detailed payment records</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('reports.maintenance') }}" class="report-card">
            <div class="report-icon" style="background:var(--warning)"><i class="bi bi-wrench"></i></div>
            <h5>Maintenance</h5>
            <p class="text-muted mb-0">Maintenance request statistics</p>
        </a>
    </div>
</div>
@endsection
