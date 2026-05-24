@extends('layouts.app')
@section('title', 'Record Meter Reading')
@section('page-title', 'Record Meter Reading')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-speedometer me-2"></i>New Reading</div>
    <div class="card-body">
        <form method="POST" action="{{ route('meter-readings.store') }}">@csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Unit *</label><select class="form-select" name="unit_id" required><option value="">Select unit...</option>@foreach($units as $u)<option value="{{ $u->id }}">{{ $u->unit_number }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Type *</label><select class="form-select" name="type" required><option value="water">Water</option><option value="electricity">Electricity</option></select></div>
                <div class="col-md-6"><label class="form-label">Previous Reading *</label><input type="number" class="form-control" name="previous_reading" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Current Reading *</label><input type="number" class="form-control" name="current_reading" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Rate per Unit (₱) *</label><input type="number" class="form-control" name="rate_per_unit" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Reading Date *</label><input type="date" class="form-control" name="reading_date" value="{{ date('Y-m-d') }}" required></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save</button> <a href="{{ route('meter-readings.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
