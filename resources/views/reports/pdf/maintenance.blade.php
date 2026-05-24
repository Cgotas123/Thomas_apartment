<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Maintenance Report</title>
<style>body{font-family:'DejaVu Sans',sans-serif;font-size:11px;color:#333}.pdf-header{text-align:center;margin-bottom:20px;border-bottom:3px solid #f4a261;padding-bottom:10px}.pdf-header h2{margin:0;color:#f4a261;font-size:18px}.pdf-header p{margin:3px 0;color:#666;font-size:10px}table{width:100%;border-collapse:collapse;margin-top:10px}th,td{border:1px solid #ddd;padding:6px 8px;text-align:left;font-size:10px}th{background:#f4a261;color:#fff;font-weight:600}.summary{margin:15px 0;padding:10px;background:#f8f9fa;border-radius:5px}</style>
</head><body>
<div class="pdf-header">
    <h2>Thomas Apartment - Maintenance Report</h2>
    <p>Generated: {{ now()->format('M d, Y h:i A') }}</p>
</div>
<div class="summary"><strong>Total Requests: {{ $total }}</strong></div>
<table>
    <thead><tr><th>Unit</th><th>Title</th><th>Description</th><th>Priority</th><th>Status</th><th>Date</th></tr></thead>
    <tbody>
        @foreach($requests as $r)
            <tr><td>{{ $r->unit->unit_number }}</td><td>{{ $r->title }}</td><td>{{ \Illuminate\Support\Str::limit($r->description, 50) }}</td><td>{{ ucfirst($r->priority) }}</td><td>{{ ucfirst(str_replace('_',' ',$r->status)) }}</td><td>{{ $r->created_at->format('M d, Y') }}</td></tr>
        @endforeach
    </tbody>
</table>
</body></html>
