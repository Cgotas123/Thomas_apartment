@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit User: {{ $user->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user) }}">@csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">New Password <small class="text-muted">(leave blank to keep)</small></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
                <div class="col-12">
                    <label class="form-label">Role *</label>
                    <select class="form-select" name="role" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update User</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
