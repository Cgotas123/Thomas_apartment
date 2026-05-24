<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Unpaid Bills Report</title>
<style>body{font-family:'DejaVu Sans',sans-serif;font-size:11px;color:#333}.pdf-header{text-align:center;margin-bottom:20px;border-bottom:3px solid #ef476f;padding-bottom:10px}.pdf-header h2{margin:0;color:#ef476f;font-size:18px}.pdf-header p{margin:3px 0;color:#666;font-size:10px}table{width:100%;border-collapse:collapse;margin-top:10px}th,td{border:1px solid #ddd;padding:6px 8px;text-align:left;font-size:10px}th{background:#ef476f;color:#fff;font-weight:600}.total-row{background:#f0f0f0;font-weight:bold}.summary{margin:15px 0;padding:10px;background:#f8f9fa;border-radius:5px}</style>
</head><body>
<div class="pdf-header">
    <h2>Thomas Apartment - Unpaid Bills Report</h2>
    <p>Generated: {{ now()->format('M d, Y h:i A') }}</p>
</div>
<div class="summary"><strong>Total Unpaid: ₱{{ number_format($totalUnpaid, 2) }}</strong> | Bills: {{ $bills->count() }}</div>
<table>
    <thead><tr><th>Unit</th><th>Tenant</th><th>Period</th><th>Rent</th><th>Water</th><th>Electricity</th><th>Total</th><th>Status</th><th>Due Date</th></tr></thead>
    <tbody>
        @foreach($bills as $b)
            <tr><td>{{ $b->lease->unit->unit_number ?? '-' }}</td><td>{{ $b->lease->tenant->full_name ?? '-' }}</td><td>{{ $b->billing_period_start->format('M Y') }}</td><td>₱{{ number_format($b->rent_amount,2) }}</td><td>₱{{ number_format($b->water_amount,2) }}</td><td>₱{{ number_format($b->electricity_amount,2) }}</td><td>₱{{ number_format($b->total_amount,2) }}</td><td>{{ ucfirst($b->status) }}</td><td>{{ $b->due_date->format('M d, Y') }}</td></tr>
        @endforeach
        <tr class="total-row"><td colspan="6">TOTAL</td><td>₱{{ number_format($totalUnpaid,2) }}</td><td colspan="2"></td></tr>
    </tbody>
</table>
</body></html>
