<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_id', 'billing_period_start', 'billing_period_end',
        'rent_amount', 'water_amount', 'electricity_amount',
        'other_charges', 'total_amount', 'status', 'due_date',
        'notes', 'created_by'
    ];

    protected $casts = [
        'billing_period_start' => 'date',
        'billing_period_end' => 'date',
        'due_date' => 'date',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    public function getBalanceAttribute()
    {
        return $this->total_amount - $this->total_paid;
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'paid' => '<span class="badge bg-success">Paid</span>',
            'unpaid' => '<span class="badge bg-danger">Unpaid</span>',
            'partial' => '<span class="badge bg-warning text-dark">Partial</span>',
            'overdue' => '<span class="badge bg-dark">Overdue</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
