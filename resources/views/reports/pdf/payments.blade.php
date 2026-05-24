<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Payment History Report</title>
<style>body{font-family:'DejaVu Sans',sans-serif;font-size:11px;color:#333}.pdf-header{text-align:center;margin-bottom:20px;border-bottom:3px solid #2dc653;padding-bottom:10px}.pdf-header h2{margin:0;color:#2dc653;font-size:18px}.pdf-header p{margin:3px 0;color:#666;font-size:10px}table{width:100%;border-collapse:collapse;margin-top:10px}th,td{border:1px solid #ddd;padding:6px 8px;text-align:left;font-size:10px}th{background:#2dc653;color:#fff;font-weight:600}.total-row{background:#f0f0f0;font-weight:bold}.summary{margin:15px 0;padding:10px;background:#f8f9fa;border-radius:5px}</style>
</head><body>
<div class="pdf-header">
    <h2>Thomas Apartment - Payment History</h2>
    <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
    <p>Generated: {{ now()->format('M d, Y h:i A') }}</p>
</div>
<div class="summary"><strong>Total: ₱{{ number_format($totalAmount, 2) }}</strong> | Transactions: {{ $payments->count() }}</div>
<table>
    <thead><tr><th>Date</th><th>Unit</th><th>Tenant</th><th>Amount</th><th>Method</th><th>Reference</th></tr></thead>
    <tbody>
        @foreach($payments as $p)
            <tr><td>{{ $p->payment_date->format('M d, Y') }}</td><td>{{ $p->bill->lease->unit->unit_number ?? '-' }}</td><td>{{ $p->bill->lease->tenant->full_name ?? '-' }}</td><td>₱{{ number_format($p->amount,2) }}</td><td>{{ ucfirst(str_replace('_',' ',$p->payment_method)) }}</td><td>{{ $p->reference_number ?? '-' }}</td></tr>
        @endforeach
        <tr class="total-row"><td colspan="3">TOTAL</td><td>₱{{ number_format($totalAmount,2) }}</td><td colspan="2"></td></tr>
    </tbody>
</table>
</body></html>
