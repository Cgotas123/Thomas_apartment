@extends('layouts.app')
@section('title', 'Maintenance Request')
@section('page-title', 'Maintenance Request #' . $maintenance->id)
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>{{ $maintenance->title }}</h5>
            <div>{!! $maintenance->priority_badge !!} {!! $maintenance->status_badge !!}</div>
        </div><hr>
        <p><strong>Unit:</strong> {{ $maintenance->unit->unit_number }}</p>
        <p><strong>Description:</strong> {{ $maintenance->description }}</p>
        <p><strong>Reported by:</strong> {{ $maintenance->reporter->name ?? '-' }}</p>
        <p><strong>Created:</strong> {{ $maintenance->created_at->format('M d, Y h:i A') }}</p>
        @if($maintenance->completed_at)<p><strong>Completed:</strong> {{ $maintenance->completed_at->format('M d, Y h:i A') }}</p>@endif
        @if($maintenance->completion_notes)<p><strong>Notes:</strong> {{ $maintenance->completion_notes }}</p>@endif
    </div>
</div>
<div class="mt-3"><a href="{{ route('maintenance.edit', $maintenance) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a> <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary">Back</a></div>
@endsection
