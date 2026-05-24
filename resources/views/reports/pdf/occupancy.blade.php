<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Occupancy Report</title>
<style>body{font-family:'DejaVu Sans',sans-serif;font-size:11px;color:#333}.pdf-header{text-align:center;margin-bottom:20px;border-bottom:3px solid #4361ee;padding-bottom:10px}.pdf-header h2{margin:0;color:#4361ee;font-size:18px}.pdf-header p{margin:3px 0;color:#666;font-size:10px}table{width:100%;border-collapse:collapse;margin-top:10px}th,td{border:1px solid #ddd;padding:6px 8px;text-align:left;font-size:10px}th{background:#4361ee;color:#fff;font-weight:600}.summary{margin:15px 0;padding:10px;background:#f8f9fa;border-radius:5px}</style>
</head><body>
<div class="pdf-header">
    <h2>Thomas Apartment - Occupancy Report</h2>
    <p>Generated: {{ now()->format('M d, Y h:i A') }}</p>
</div>
<div class="summary"><strong>Total Units: {{ $total }}</strong> | Occupied: {{ $occupied }} | Occupancy Rate: {{ $rate }}%</div>
<table>
    <thead><tr><th>Unit #</th><th>Floor</th><th>Type</th><th>Rent</th><th>Status</th><th>Tenant</th></tr></thead>
    <tbody>
        @foreach($units as $u)
            <tr><td>{{ $u->unit_number }}</td><td>{{ $u->floor }}</td><td>{{ $u->type_label }}</td><td>₱{{ number_format($u->monthly_rent,2) }}</td><td>{{ ucfirst($u->status) }}</td><td>{{ $u->activeLease?->tenant?->full_name ?? '-' }}</td></tr>
        @endforeach
    </tbody>
</table>
</body></html>
