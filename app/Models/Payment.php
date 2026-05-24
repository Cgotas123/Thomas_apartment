<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id', 'amount', 'payment_method', 'reference_number',
        'payment_date', 'received_by', 'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function getMethodBadgeAttribute()
    {
        return match($this->payment_method) {
            'cash' => '<span class="badge bg-success">Cash</span>',
            'bank_transfer' => '<span class="badge bg-primary">Bank Transfer</span>',
            'gcash' => '<span class="badge bg-info">GCash</span>',
            'maya' => '<span class="badge bg-purple">Maya</span>',
            default => '<span class="badge bg-secondary">Other</span>',
        };
    }
}
