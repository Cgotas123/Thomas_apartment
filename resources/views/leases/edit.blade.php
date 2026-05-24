@extends('layouts.app')
@section('title', 'Edit Lease')
@section('page-title', 'Edit Lease')
@section('content')
<div class="card-custom" style="max-width:700px">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Lease</div>
    <div class="card-body">
        <form method="POST" action="{{ route('leases.update', $lease) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Tenant *</label><select class="form-select" name="tenant_id" required>@foreach($tenants as $t)<option value="{{ $t->id }}" {{ $lease->tenant_id==$t->id?'selected':'' }}>{{ $t->full_name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Unit *</label><select class="form-select" name="unit_id" required>@foreach($units as $u)<option value="{{ $u->id }}" {{ $lease->unit_id==$u->id?'selected':'' }}>{{ $u->unit_number }} - {{ $u->type_label }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Start Date *</label><input type="date" class="form-control" name="start_date" value="{{ $lease->start_date->format('Y-m-d') }}" required></div>
                <div class="col-md-6"><label class="form-label">End Date *</label><input type="date" class="form-control" name="end_date" value="{{ $lease->end_date->format('Y-m-d') }}" required></div>
                <div class="col-md-6"><label class="form-label">Monthly Rent *</label><input type="number" class="form-control" name="monthly_rent" value="{{ $lease->monthly_rent }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Deposit *</label><input type="number" class="form-control" name="deposit" value="{{ $lease->deposit }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status">@foreach(['active'=>'Active','expired'=>'Expired','terminated'=>'Terminated'] as $k=>$v)<option value="{{ $k }}" {{ $lease->status==$k?'selected':'' }}>{{ $v }}</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes" rows="2">{{ $lease->notes }}</textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button> <a href="{{ route('leases.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
