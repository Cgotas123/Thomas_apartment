@extends('layouts.app')
@section('title', 'Add Tenant')
@section('page-title', 'Add Tenant')

@section('content')
<div class="card-custom" style="max-width:800px">
    <div class="card-header"><i class="bi bi-person-plus me-2"></i>New Tenant</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name *</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone *</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ID Type</label>
                    <select class="form-select" name="id_type">
                        <option value="">Select...</option>
                        <option value="National ID">National ID</option>
                        <option value="Passport">Passport</option>
                        <option value="Driver License">Driver's License</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ID Number</label>
                    <input type="text" class="form-control" name="id_number" value="{{ old('id_number') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact</label>
                    <input type="text" class="form-control" name="emergency_contact" value="{{ old('emergency_contact') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact Phone</label>
                    <input type="text" class="form-control" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Tenant</button>
                <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
