@extends('layouts.app')
@section('title', 'Record Payment')
@section('page-title', 'Record Payment')
@section('content')
<div class="card-custom" style="max-width:600px">
    <div class="card-header"><i class="bi bi-cash me-2"></i>New Payment</div>
    <div class="card-body">
        <form method="POST" action="{{ route('payments.store') }}">@csrf
            <div class="row g-3">
                <div class="col-12"><label class="form-label">Bill *</label><select class="form-select" name="bill_id" required><option value="">Select bill...</option>@foreach($bills as $b)<option value="{{ $b->id }}" {{ ($selectedBill && $selectedBill->id==$b->id)?'selected':'' }}>Bill #{{ $b->id }} - Unit {{ $b->lease->unit->unit_number }} - {{ $b->lease->tenant->full_name }} (₱{{ number_format($b->total_amount - $b->payments->sum('amount'),2) }} remaining)</option>@endforeach</select></div>
                <div class="col-md-6"><label class="form-label">Amount (₱) *</label><input type="number" class="form-control" name="amount" step="0.01" value="{{ $selectedBill ? $selectedBill->total_amount - $selectedBill->payments->sum('amount') : '' }}" required></div>
                <div class="col-md-6"><label class="form-label">Payment Method *</label><select class="form-select" name="payment_method" required><option value="cash">Cash</option><option value="bank_transfer">Bank Transfer</option><option value="gcash">GCash</option><option value="maya">Maya</option></select></div>
                <div class="col-md-6"><label class="form-label">Reference Number</label><input type="text" class="form-control" name="reference_number"></div>
                <div class="col-md-6"><label class="form-label">Payment Date *</label><input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}" required></div>
                <div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes" rows="2"></textarea></div>
            </div>
            <div class="mt-4"><button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Record Payment</button> <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
