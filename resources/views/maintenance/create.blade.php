@extends('layouts.app')
@section('title', 'New Maintenance Request')
@section('page-title', 'New Maintenance Request')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-wrench me-2"></i>New Request</div>
    <div class="card-body">
        <form method="POST" action="{{ route('maintenance.store') }}">@csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Unit *</label><select class="form-select" name="unit_id" required><option value="">Select unit...</option>@foreach($units as $u)<option value="{{ $u->id }}">{{ $u->unit_number }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Priority *</label><select class="form-select" name="priority" required><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option><option value="urgent">Urgent</option></select></div>
                <div class="col-12"><label class="form-label">Title *</label><input type="text" class="form-control" name="title" required></div>
                <div class="col-12"><label class="form-label">Description *</label><textarea class="form-control" name="description" rows="3" required></textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Submit</button> <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
