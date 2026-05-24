@extends('layouts.app')
@section('title', 'Edit Tenant')
@section('page-title', 'Edit Tenant')

@section('content')
<div class="card-custom" style="max-width:800px">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit Tenant: {{ $tenant->full_name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tenants.update', $tenant) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $tenant->first_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name *</label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $tenant->last_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone *</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $tenant->phone) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $tenant->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth', $tenant->date_of_birth?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ID Type</label>
                    <select class="form-select" name="id_type">
                        <option value="">Select...</option>
                        @foreach(['National ID','Passport','Driver License'] as $t)
                            <option value="{{ $t }}" {{ $tenant->id_type == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">ID Number</label>
                    <input type="text" class="form-control" name="id_number" value="{{ old('id_number', $tenant->id_number) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact</label>
                    <input type="text" class="form-control" name="emergency_contact" value="{{ old('emergency_contact', $tenant->emergency_contact) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact Phone</label>
                    <input type="text" class="form-control" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $tenant->emergency_contact_phone) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" name="address" rows="2">{{ old('address', $tenant->address) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
                <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
