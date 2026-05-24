@extends('layouts.app')
@section('title', 'Payment Details')
@section('page-title', 'Payment #' . $payment->id)
@section('content')
<div class="card-custom" style="max-width:500px">
    <div class="card-body">
        <h5>Payment Details</h5><hr>
        <p><strong>Amount:</strong> <span class="text-success fs-5">₱{{ number_format($payment->amount,2) }}</span></p>
        <p><strong>Bill:</strong> #{{ $payment->bill_id }}</p>
        <p><strong>Unit:</strong> {{ $payment->bill->lease->unit->unit_number ?? 'N/A' }}</p>
        <p><strong>Tenant:</strong> {{ $payment->bill->lease->tenant->full_name ?? 'N/A' }}</p>
        <p><strong>Method:</strong> {!! $payment->method_badge !!}</p>
        <p><strong>Reference:</strong> {{ $payment->reference_number ?? '-' }}</p>
        <p><strong>Date:</strong> {{ $payment->payment_date->format('M d, Y') }}</p>
        <p><strong>Received by:</strong> {{ $payment->receiver->name ?? '-' }}</p>
        <p><strong>Notes:</strong> {{ $payment->notes ?? '-' }}</p>
    </div>
</div>
<div class="mt-3"><a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Back</a></div>
@endsection
