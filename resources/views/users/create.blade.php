@extends('layouts.app')
@section('title', 'Add User')
@section('page-title', 'Add User')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-person-plus me-2"></i>New User</div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">@csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Role *</label>
                    <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create User</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
