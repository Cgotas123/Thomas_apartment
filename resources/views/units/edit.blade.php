@extends('layouts.app')
@section('title', 'Edit Unit')
@section('page-title', 'Edit Unit')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Unit {{ $unit->unit_number }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('units.update', $unit) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Unit Number *</label><input type="text" class="form-control" name="unit_number" value="{{ old('unit_number', $unit->unit_number) }}" required></div>
                <div class="col-md-6"><label class="form-label">Floor *</label><input type="number" class="form-control" name="floor" value="{{ old('floor', $unit->floor) }}" min="1" required></div>
                <div class="col-md-6"><label class="form-label">Type *</label><select class="form-select" name="type" required>@foreach(['studio'=>'Studio','1br'=>'1 Bedroom','2br'=>'2 Bedrooms','3br'=>'3 Bedrooms'] as $k=>$v)<option value="{{ $k }}" {{ $unit->type==$k?'selected':'' }}>{{ $v }}</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Monthly Rent *</label><input type="number" class="form-control" name="monthly_rent" value="{{ old('monthly_rent', $unit->monthly_rent) }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status">@foreach(['vacant'=>'Vacant','occupied'=>'Occupied','maintenance'=>'Maintenance'] as $k=>$v)<option value="{{ $k }}" {{ $unit->status==$k?'selected':'' }}>{{ $v }}</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="2">{{ old('description', $unit->description) }}</textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button> <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
