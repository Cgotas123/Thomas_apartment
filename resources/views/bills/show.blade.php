@extends('layouts.app')
@section('title', 'Bill Details')
@section('page-title', 'Bill #' . $bill->id)
@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-3">
    <div class="col-md-5">
        <div class="card-custom"><div class="card-body">
            <h5>Bill Summary {!! $bill->status_badge !!}</h5><hr>
            <p><strong>Unit:</strong> {{ $bill->lease->unit->unit_number ?? 'N/A' }}</p>
            <p><strong>Tenant:</strong> {{ $bill->lease->tenant->full_name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $bill->lease->tenant->email ?? 'No email' }}</p>
            <p><strong>Period:</strong> {{ $bill->billing_period_start->format('M d') }} - {{ $bill->billing_period_end->format('M d, Y') }}</p>
            <hr>
            <p>Rent: <span class="float-end">₱{{ number_format($bill->rent_amount,2) }}</span></p>
            <p>Water: <span class="float-end">₱{{ number_format($bill->water_amount,2) }}</span></p>
            <p>Electricity: <span class="float-end">₱{{ number_format($bill->electricity_amount,2) }}</span></p>
            <p>Other: <span class="float-end">₱{{ number_format($bill->other_charges,2) }}</span></p>
            <hr>
            <p><strong>Total: <span class="float-end text-primary">₱{{ number_format($bill->total_amount,2) }}</span></strong></p>
            <p><strong>Paid: <span class="float-end text-success">₱{{ number_format($bill->total_paid,2) }}</span></strong></p>
            <p><strong>Balance: <span class="float-end text-danger">₱{{ number_format($bill->balance,2) }}</span></strong></p>
            <p><strong>Due Date:</strong> {{ $bill->due_date->format('M d, Y') }}</p>
        </div></div>
    </div>
    <div class="col-md-7">
        <div class="card-custom"><div class="card-header"><span>Payments</span>
            @if($bill->balance > 0)<a href="{{ route('payments.create') }}?bill_id={{ $bill->id }}" class="btn btn-sm btn-success"><i class="bi bi-plus-lg me-1"></i>Record Payment</a>@endif
        </div>
        <div class="card-body p-0"><table class="table-custom"><thead><tr><th>Date</th><th>Amount</th><th>Method</th><th>Reference</th></tr></thead>
        <tbody>
            @forelse($bill->payments as $p)
                <tr><td>{{ $p->payment_date->format('M d, Y') }}</td><td>₱{{ number_format($p->amount,2) }}</td><td>{!! $p->method_badge !!}</td><td>{{ $p->reference_number ?? '-' }}</td></tr>
            @empty
                <tr><td colspan="4" class="text-center py-3">No payments</td></tr>
            @endforelse
        </tbody></table></div></div>
    </div>
</div>

<div class="mt-3 d-flex gap-2 flex-wrap">
    <a href="{{ route('bills.edit', $bill) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>

    {{-- Send Email Button --}}
    @if($bill->lease->tenant->email)
    <form action="{{ route('bills.send-email', $bill) }}" method="POST" class="d-inline" onsubmit="return confirm('Send bill notification to {{ $bill->lease->tenant->email }}?');">
        @csrf
        <button type="submit" class="btn btn-info text-white">
            <i class="bi bi-envelope me-1"></i>Send Bill via Email
        </button>
    </form>
    @else
    <button class="btn btn-secondary" disabled title="Tenant has no email address">
        <i class="bi bi-envelope me-1"></i>No Email Available
    </button>
    @endif

    <a href="{{ route('bills.index') }}" class="btn btn-outline-secondary">Back</a>
</div>
@endsection
