<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'unit_id', 'start_date', 'end_date',
        'monthly_rent', 'deposit', 'status', 'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active' => '<span class="badge bg-success">Active</span>',
            'expired' => '<span class="badge bg-secondary">Expired</span>',
            'terminated' => '<span class="badge bg-danger">Terminated</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
