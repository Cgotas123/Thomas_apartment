@extends('layouts.app')
@section('title', 'Meter Reading Details')
@section('page-title', 'Meter Reading Details')
@section('content')
<div class="card-custom" style="max-width:500px">
    <div class="card-body">
        <h5>Unit {{ $meterReading->unit->unit_number }} - {!! $meterReading->type_badge !!}</h5><hr>
        <p><strong>Previous:</strong> {{ number_format($meterReading->previous_reading,2) }}</p>
        <p><strong>Current:</strong> {{ number_format($meterReading->current_reading,2) }}</p>
        <p><strong>Consumption:</strong> {{ number_format($meterReading->consumption,2) }}</p>
        <p><strong>Rate:</strong> ₱{{ number_format($meterReading->rate_per_unit,2) }}</p>
        <p><strong>Total:</strong> ₱{{ number_format($meterReading->total_amount,2) }}</p>
        <p><strong>Date:</strong> {{ $meterReading->reading_date->format('M d, Y') }}</p>
        <p><strong>Recorded by:</strong> {{ $meterReading->recorder->name ?? '-' }}</p>
    </div>
</div>
<div class="mt-3"><a href="{{ route('meter-readings.index') }}" class="btn btn-outline-secondary">Back</a></div>
@endsection
