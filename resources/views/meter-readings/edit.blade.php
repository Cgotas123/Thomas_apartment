@extends('layouts.app')
@section('title', 'Edit Meter Reading')
@section('page-title', 'Edit Meter Reading')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Reading</div>
    <div class="card-body">
        <form method="POST" action="{{ route('meter-readings.update', $meterReading) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Unit *</label><select class="form-select" name="unit_id" required>@foreach($units as $u)<option value="{{ $u->id }}" {{ $meterReading->unit_id==$u->id?'selected':'' }}>{{ $u->unit_number }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Type *</label><select class="form-select" name="type" required><option value="water" {{ $meterReading->type=='water'?'selected':'' }}>Water</option><option value="electricity" {{ $meterReading->type=='electricity'?'selected':'' }}>Electricity</option></select></div>
                <div class="col-md-6"><label class="form-label">Previous Reading *</label><input type="number" class="form-control" name="previous_reading" value="{{ $meterReading->previous_reading }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Current Reading *</label><input type="number" class="form-control" name="current_reading" value="{{ $meterReading->current_reading }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Rate per Unit (₱) *</label><input type="number" class="form-control" name="rate_per_unit" value="{{ $meterReading->rate_per_unit }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Reading Date *</label><input type="date" class="form-control" name="reading_date" value="{{ $meterReading->reading_date->format('Y-m-d') }}" required></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button> <a href="{{ route('meter-readings.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
