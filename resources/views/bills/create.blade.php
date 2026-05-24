@extends('layouts.app')
@section('title', 'New Bill')
@section('page-title', 'Create Bill')
@section('content')
<div class="card-custom" style="max-width:700px">
    <div class="card-header"><i class="bi bi-receipt me-2"></i>New Bill</div>
    <div class="card-body">
        <form method="POST" action="{{ route('bills.store') }}">@csrf
            <div class="row g-3">
                <div class="col-md-12"><label class="form-label">Lease (Unit - Tenant) *</label><select class="form-select" name="lease_id" required><option value="">Select...</option>@foreach($leases as $l)<option value="{{ $l->id }}">Unit {{ $l->unit->unit_number }} - {{ $l->tenant->full_name }} (₱{{ number_format($l->monthly_rent,2) }}/mo)</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Billing Start *</label><input type="date" class="form-control" name="billing_period_start" required></div>
                <div class="col-md-6"><label class="form-label">Billing End *</label><input type="date" class="form-control" name="billing_period_end" required></div>
                <div class="col-md-6"><label class="form-label">Rent Amount (₱) *</label><input type="number" class="form-control" name="rent_amount" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Water Amount (₱) *</label><input type="number" class="form-control" name="water_amount" step="0.01" value="0" required></div>
                <div class="col-md-6"><label class="form-label">Electricity Amount (₱) *</label><input type="number" class="form-control" name="electricity_amount" step="0.01" value="0" required></div>
                <div class="col-md-6"><label class="form-label">Other Charges (₱)</label><input type="number" class="form-control" name="other_charges" step="0.01" value="0"></div>
                <div class="col-md-6"><label class="form-label">Due Date *</label><input type="date" class="form-control" name="due_date" required></div>
                <div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes" rows="2"></textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create Bill</button> <a href="{{ route('bills.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
