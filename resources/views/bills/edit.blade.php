@extends('layouts.app')
@section('title', 'Edit Bill')
@section('page-title', 'Edit Bill')
@section('content')
<div class="card-custom" style="max-width:700px">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Bill #{{ $bill->id }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('bills.update', $bill) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-12"><label class="form-label">Lease *</label><select class="form-select" name="lease_id" required>@foreach($leases as $l)<option value="{{ $l->id }}" {{ $bill->lease_id==$l->id?'selected':'' }}>Unit {{ $l->unit->unit_number }} - {{ $l->tenant->full_name }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Billing Start *</label><input type="date" class="form-control" name="billing_period_start" value="{{ $bill->billing_period_start->format('Y-m-d') }}" required></div>
                <div class="col-md-6"><label class="form-label">Billing End *</label><input type="date" class="form-control" name="billing_period_end" value="{{ $bill->billing_period_end->format('Y-m-d') }}" required></div>
                <div class="col-md-6"><label class="form-label">Rent (₱) *</label><input type="number" class="form-control" name="rent_amount" value="{{ $bill->rent_amount }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Water (₱) *</label><input type="number" class="form-control" name="water_amount" value="{{ $bill->water_amount }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Electricity (₱) *</label><input type="number" class="form-control" name="electricity_amount" value="{{ $bill->electricity_amount }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Other (₱)</label><input type="number" class="form-control" name="other_charges" value="{{ $bill->other_charges }}" step="0.01"></div>
                <div class="col-md-6"><label class="form-label">Due Date *</label><input type="date" class="form-control" name="due_date" value="{{ $bill->due_date->format('Y-m-d') }}" required></div>
                <div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status">@foreach(['unpaid'=>'Unpaid','partial'=>'Partial','paid'=>'Paid','overdue'=>'Overdue'] as $k=>$v)<option value="{{ $k }}" {{ $bill->status==$k?'selected':'' }}>{{ $v }}</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes" rows="2">{{ $bill->notes }}</textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button> <a href="{{ route('bills.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
