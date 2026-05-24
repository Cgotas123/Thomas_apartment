@extends('layouts.app')
@section('title', 'User Management')
@section('page-title', 'User Management')
@section('content')
<div class="filter-bar d-flex justify-content-between align-items-center">
    <h6 class="mb-0"><i class="bi bi-person-gear me-2"></i>System Users</h6>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add User</a>
</div>
<div class="card-custom"><div class="card-body p-0"><div class="table-responsive">
    <table class="table-custom"><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td><span class="badge {{ $user->hasRole('admin') ? 'bg-primary' : 'bg-info' }}">{{ ucfirst($user->getRoleNames()->first() ?? 'N/A') }}</span></td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="bi bi-pencil"></i></a>
                    @if($user->id !== auth()->id())
                        <form id="del-usr-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('del-usr-{{ $user->id }}')" class="btn btn-sm btn-outline-danger btn-icon"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody></table>
</div></div></div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
