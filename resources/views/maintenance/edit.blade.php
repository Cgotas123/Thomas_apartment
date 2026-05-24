@extends('layouts.app')
@section('title', 'Edit Maintenance Request')
@section('page-title', 'Edit Maintenance Request')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Request #{{ $maintenance->id }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('maintenance.update', $maintenance) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Unit *</label><select class="form-select" name="unit_id" required>@foreach($units as $u)<option value="{{ $u->id }}" {{ $maintenance->unit_id==$u->id?'selected':'' }}>{{ $u->unit_number }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Priority *</label><select class="form-select" name="priority">@foreach(['low'=>'Low','medium'=>'Medium','high'=>'High','urgent'=>'Urgent'] as $k=>$v)<option value="{{ $k }}" {{ $maintenance->priority==$k?'selected':'' }}>{{ $v }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Status *</label><select class="form-select" name="status">@foreach(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $k=>$v)<option value="{{ $k }}" {{ $maintenance->status==$k?'selected':'' }}>{{ $v }}</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label">Title *</label><input type="text" class="form-control" name="title" value="{{ $maintenance->title }}" required></div>
                <div class="col-12"><label class="form-label">Description *</label><textarea class="form-control" name="description" rows="3" required>{{ $maintenance->description }}</textarea></div>
                <div class="col-12"><label class="form-label">Completion Notes</label><textarea class="form-control" name="completion_notes" rows="2">{{ $maintenance->completion_notes }}</textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button> <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
