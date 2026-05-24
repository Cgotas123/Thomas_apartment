<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Statement</title>
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e293b, #334155); padding: 30px 40px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px; font-weight:700;">Thomas Apartment</h1>
                            <p style="color:#94a3b8; margin:5px 0 0; font-size:14px;">Billing Statement</p>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding: 30px 40px 15px;">
                            <p style="color:#334155; font-size:16px; margin:0;">Dear <strong>{{ $tenant->full_name }}</strong>,</p>
                            <p style="color:#64748b; font-size:14px; margin:10px 0 0;">Here is your billing statement for unit <strong>{{ $unit->unit_number }}</strong>.</p>
                        </td>
                    </tr>

                    <!-- Billing Period -->
                    <tr>
                        <td style="padding: 10px 40px;">
                            <table width="100%" style="background:#f8fafc; border-radius:8px; padding:15px;">
                                <tr>
                                    <td style="padding:10px 15px;">
                                        <p style="color:#94a3b8; font-size:12px; margin:0; text-transform:uppercase; letter-spacing:1px;">Billing Period</p>
                                        <p style="color:#1e293b; font-size:15px; margin:5px 0 0; font-weight:600;">
                                            {{ $bill->billing_period_start->format('M d') }} - {{ $bill->billing_period_end->format('M d, Y') }}
                                        </p>
                                    </td>
                                    <td style="padding:10px 15px; text-align:right;">
                                        <p style="color:#94a3b8; font-size:12px; margin:0; text-transform:uppercase; letter-spacing:1px;">Due Date</p>
                                        <p style="color:#ef4444; font-size:15px; margin:5px 0 0; font-weight:600;">
                                            {{ $bill->due_date->format('M d, Y') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    @if($meterReadings->count() > 0)
                    <!-- Consumption Details -->
                    <tr>
                        <td style="padding: 15px 40px 5px;">
                            <h3 style="color:#1e293b; font-size:16px; margin:0; border-bottom:2px solid #e2e8f0; padding-bottom:8px;">
                                📊 Consumption Details
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 40px 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0; border-radius:8px; overflow:hidden;">
                                <tr style="background:#f8fafc;">
                                    <th style="padding:10px 12px; text-align:left; color:#64748b; font-size:12px; text-transform:uppercase; border-bottom:1px solid #e2e8f0;">Type</th>
                                    <th style="padding:10px 12px; text-align:center; color:#64748b; font-size:12px; text-transform:uppercase; border-bottom:1px solid #e2e8f0;">Previous</th>
                                    <th style="padding:10px 12px; text-align:center; color:#64748b; font-size:12px; text-transform:uppercase; border-bottom:1px solid #e2e8f0;">Current</th>
                                    <th style="padding:10px 12px; text-align:center; color:#64748b; font-size:12px; text-transform:uppercase; border-bottom:1px solid #e2e8f0;">Usage</th>
                                    <th style="padding:10px 12px; text-align:right; color:#64748b; font-size:12px; text-transform:uppercase; border-bottom:1px solid #e2e8f0;">Rate</th>
                                    <th style="padding:10px 12px; text-align:right; color:#64748b; font-size:12px; text-transform:uppercase; border-bottom:1px solid #e2e8f0;">Amount</th>
                                </tr>
                                @foreach($meterReadings as $reading)
                                <tr>
                                    <td style="padding:10px 12px; color:#334155; font-size:13px; border-bottom:1px solid #f1f5f9;">
                                        @if($reading->type == 'water')
                                            💧 Water
                                        @else
                                            ⚡ Electricity
                                        @endif
                                    </td>
                                    <td style="padding:10px 12px; text-align:center; color:#64748b; font-size:13px; border-bottom:1px solid #f1f5f9;">{{ number_format($reading->previous_reading, 2) }}</td>
                                    <td style="padding:10px 12px; text-align:center; color:#64748b; font-size:13px; border-bottom:1px solid #f1f5f9;">{{ number_format($reading->current_reading, 2) }}</td>
                                    <td style="padding:10px 12px; text-align:center; color:#1e293b; font-size:13px; font-weight:600; border-bottom:1px solid #f1f5f9;">{{ number_format($reading->consumption, 2) }}</td>
                                    <td style="padding:10px 12px; text-align:right; color:#64748b; font-size:13px; border-bottom:1px solid #f1f5f9;">₱{{ number_format($reading->rate_per_unit, 2) }}</td>
                                    <td style="padding:10px 12px; text-align:right; color:#1e293b; font-size:13px; font-weight:600; border-bottom:1px solid #f1f5f9;">₱{{ number_format($reading->total_amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    @endif

                    <!-- Bill Breakdown -->
                    <tr>
                        <td style="padding: 15px 40px 5px;">
                            <h3 style="color:#1e293b; font-size:16px; margin:0; border-bottom:2px solid #e2e8f0; padding-bottom:8px;">
                                💰 Bill Breakdown
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 40px 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:8px 0; color:#64748b; font-size:14px;">Monthly Rent</td>
                                    <td style="padding:8px 0; text-align:right; color:#334155; font-size:14px;">₱{{ number_format($bill->rent_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#64748b; font-size:14px; border-top:1px solid #f1f5f9;">💧 Water Charges</td>
                                    <td style="padding:8px 0; text-align:right; color:#334155; font-size:14px; border-top:1px solid #f1f5f9;">₱{{ number_format($bill->water_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#64748b; font-size:14px; border-top:1px solid #f1f5f9;">⚡ Electricity Charges</td>
                                    <td style="padding:8px 0; text-align:right; color:#334155; font-size:14px; border-top:1px solid #f1f5f9;">₱{{ number_format($bill->electricity_amount, 2) }}</td>
                                </tr>
                                @if($bill->other_charges > 0)
                                <tr>
                                    <td style="padding:8px 0; color:#64748b; font-size:14px; border-top:1px solid #f1f5f9;">Other Charges</td>
                                    <td style="padding:8px 0; text-align:right; color:#334155; font-size:14px; border-top:1px solid #f1f5f9;">₱{{ number_format($bill->other_charges, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding:12px 0; color:#1e293b; font-size:16px; font-weight:700; border-top:2px solid #e2e8f0;">TOTAL AMOUNT</td>
                                    <td style="padding:12px 0; text-align:right; color:#3b82f6; font-size:18px; font-weight:700; border-top:2px solid #e2e8f0;">₱{{ number_format($bill->total_amount, 2) }}</td>
                                </tr>
                                @if($bill->total_paid > 0)
                                <tr>
                                    <td style="padding:8px 0; color:#16a34a; font-size:14px;">Amount Paid</td>
                                    <td style="padding:8px 0; text-align:right; color:#16a34a; font-size:14px;">- ₱{{ number_format($bill->total_paid, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#ef4444; font-size:16px; font-weight:700; border-top:1px solid #e2e8f0;">BALANCE DUE</td>
                                    <td style="padding:10px 0; text-align:right; color:#ef4444; font-size:18px; font-weight:700; border-top:1px solid #e2e8f0;">₱{{ number_format($bill->balance, 2) }}</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    @if($bill->notes)
                    <!-- Notes -->
                    <tr>
                        <td style="padding: 5px 40px 15px;">
                            <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:8px; padding:12px 15px;">
                                <p style="color:#92400e; font-size:13px; margin:0;"><strong>Note:</strong> {{ $bill->notes }}</p>
                            </div>
                        </td>
                    </tr>
                    @endif

                    <!-- Payment Reminder -->
                    <tr>
                        <td style="padding: 10px 40px 25px;">
                            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:15px; text-align:center;">
                                <p style="color:#1e40af; font-size:14px; margin:0; font-weight:600;">📌 Please settle your payment on or before {{ $bill->due_date->format('F d, Y') }}</p>
                                <p style="color:#3b82f6; font-size:13px; margin:8px 0 0;">Contact management for payment methods and concerns.</p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8fafc; padding: 20px 40px; text-align:center; border-top:1px solid #e2e8f0;">
                            <p style="color:#94a3b8; font-size:12px; margin:0;">This is an automated billing notification from</p>
                            <p style="color:#64748b; font-size:13px; margin:5px 0 0; font-weight:600;">Thomas Apartment Management System</p>
                            <p style="color:#cbd5e1; font-size:11px; margin:10px 0 0;">Generated on {{ now()->format('F d, Y h:i A') }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
