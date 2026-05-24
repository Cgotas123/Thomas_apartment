@extends('layouts.app')
@section('title', 'Add Unit')
@section('page-title', 'Add Unit')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-door-open me-2"></i>New Unit</div>
    <div class="card-body">
        <form method="POST" action="{{ route('units.store') }}">@csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Unit Number *</label><input type="text" class="form-control @error('unit_number') is-invalid @enderror" name="unit_number" value="{{ old('unit_number') }}" required>@error('unit_number')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label class="form-label">Floor *</label><input type="number" class="form-control" name="floor" value="{{ old('floor', 1) }}" min="1" required></div>
                <div class="col-md-6"><label class="form-label">Type *</label><select class="form-select" name="type" required><option value="studio">Studio</option><option value="1br">1 Bedroom</option><option value="2br">2 Bedrooms</option><option value="3br">3 Bedrooms</option></select></div>
                <div class="col-md-6"><label class="form-label">Monthly Rent *</label><input type="number" class="form-control" name="monthly_rent" value="{{ old('monthly_rent') }}" step="0.01" required></div>
                <div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status"><option value="vacant">Vacant</option><option value="occupied">Occupied</option><option value="maintenance">Maintenance</option></select></div>
                <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="2">{{ old('description') }}</textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save</button> <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
