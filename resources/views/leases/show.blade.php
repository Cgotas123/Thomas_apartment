@extends('layouts.app')
@section('title', 'Lease Details')
@section('page-title', 'Lease Details')
@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card-custom"><div class="card-body">
            <h5>Lease Information</h5><hr>
            <p><strong>Unit:</strong> {{ $lease->unit->unit_number }}</p>
            <p><strong>Tenant:</strong> {{ $lease->tenant->full_name }}</p>
            <p><strong>Period:</strong> {{ $lease->start_date->format('M d, Y') }} - {{ $lease->end_date->format('M d, Y') }}</p>
            <p><strong>Rent:</strong> ₱{{ number_format($lease->monthly_rent, 2) }}</p>
            <p><strong>Deposit:</strong> ₱{{ number_format($lease->deposit, 2) }}</p>
            <p><strong>Status:</strong> {!! $lease->status_badge !!}</p>
        </div></div>
    </div>
    <div class="col-md-8">
        <div class="card-custom"><div class="card-header"><span>Bills</span><a href="{{ route('bills.create') }}?lease_id={{ $lease->id }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>New Bill</a></div>
        <div class="card-body p-0"><table class="table-custom"><thead><tr><th>Period</th><th>Amount</th><th>Status</th><th>Due</th></tr></thead>
        <tbody>
            @forelse($lease->bills as $bill)
                <tr><td>{{ $bill->billing_period_start->format('M Y') }}</td><td>₱{{ number_format($bill->total_amount,2) }}</td><td>{!! $bill->status_badge !!}</td><td>{{ $bill->due_date->format('M d, Y') }}</td></tr>
            @empty
                <tr><td colspan="4" class="text-center py-3">No bills</td></tr>
            @endforelse
        </tbody></table></div></div>
    </div>
</div>
<div class="mt-3"><a href="{{ route('leases.edit', $lease) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a> <a href="{{ route('leases.index') }}" class="btn btn-outline-secondary">Back</a></div>
@endsection
