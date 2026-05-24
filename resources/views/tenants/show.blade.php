@extends('layouts.app')
@section('title', 'Tenant Details')
@section('page-title', 'Tenant Details')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card-custom">
            <div class="card-body text-center">
                <div class="user-avatar mx-auto mb-3" style="width:80px;height:80px;font-size:2rem">{{ strtoupper(substr($tenant->first_name,0,1)) }}</div>
                <h4>{{ $tenant->full_name }}</h4>
                <p class="text-muted mb-2">{{ $tenant->email ?? 'No email' }}</p>
                <p><i class="bi bi-telephone me-1"></i>{{ $tenant->phone }}</p>
                @if($tenant->activeLease)
                    <span class="badge bg-success">Unit {{ $tenant->activeLease->unit->unit_number }}</span>
                @else
                    <span class="badge bg-secondary">No Active Lease</span>
                @endif
            </div>
        </div>
        <div class="card-custom">
            <div class="card-header">Personal Info</div>
            <div class="card-body">
                <p><strong>Date of Birth:</strong> {{ $tenant->date_of_birth?->format('M d, Y') ?? '-' }}</p>
                <p><strong>ID Type:</strong> {{ $tenant->id_type ?? '-' }}</p>
                <p><strong>ID Number:</strong> {{ $tenant->id_number ?? '-' }}</p>
                <p><strong>Emergency Contact:</strong> {{ $tenant->emergency_contact ?? '-' }}</p>
                <p><strong>Emergency Phone:</strong> {{ $tenant->emergency_contact_phone ?? '-' }}</p>
                <p><strong>Address:</strong> {{ $tenant->address ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header"><span><i class="bi bi-file-earmark-text me-2"></i>Lease History</span></div>
            <div class="card-body p-0">
                <table class="table-custom">
                    <thead><tr><th>Unit</th><th>Period</th><th>Rent</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($tenant->leases as $lease)
                            <tr>
                                <td>{{ $lease->unit->unit_number }}</td>
                                <td>{{ $lease->start_date->format('M Y') }} - {{ $lease->end_date->format('M Y') }}</td>
                                <td>₱{{ number_format($lease->monthly_rent, 2) }}</td>
                                <td>{!! $lease->status_badge !!}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-3">No leases found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="mt-3">
    <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
    <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">Back</a>
</div>
@endsection
