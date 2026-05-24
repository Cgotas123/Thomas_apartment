<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'lease_id',
        'billing_date',
        'due_date',
        'period_start',
        'period_end',
        'rent_amount',
        'electricity_amount',
        'water_amount',
        'wifi_fee',
        'other_fees',
        'total_amount',
        'status'
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function getDurationAttribute()
    {
        return $this->period_start->format('M d') . ' - ' . $this->period_end->format('M d, Y');
    }

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'billing_date' => 'date',
        'due_date' => 'date',
    ];
}
