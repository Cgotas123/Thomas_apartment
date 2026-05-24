@extends('layouts.app')
@section('title', 'New Lease')
@section('page-title', 'New Lease')
@section('content')
<div class="card-custom" style="max-width:700px">
    <div class="card-header"><i class="bi bi-file-earmark-plus me-2"></i>Create Lease</div>
    <div class="card-body">
        <form method="POST" action="{{ route('leases.store') }}">@csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Tenant *</label><select class="form-select" name="tenant_id" required><option value="">Select tenant...</option>@foreach($tenants as $t)<option value="{{ $t->id }}">{{ $t->full_name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Unit *</label><select class="form-select" name="unit_id" required><option value="">Select unit...</option>@foreach($units as $u)<option value="{{ $u->id }}">{{ $u->unit_number }} - {{ $u->type_label }} (₱{{ number_format($u->monthly_rent,2) }})</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Start Date *</label><input type="date" class="form-control" name="start_date" required></div>
                <div class="col-md-6"><label class="form-label">End Date *</label><input type="date" class="form-control" name="end_date" required></div>
                <div class="col-md-6"><label class="form-label">Monthly Rent *</label><input type="number" class="form-control" name="monthly_rent" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Deposit *</label><input type="number" class="form-control" name="deposit" step="0.01" value="0" required></div>
                <div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status"><option value="active">Active</option><option value="expired">Expired</option><option value="terminated">Terminated</option></select></div>
                <div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes" rows="2"></textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create Lease</button> <a href="{{ route('leases.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
