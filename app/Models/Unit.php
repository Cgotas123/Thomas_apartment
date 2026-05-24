<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_number', 'floor', 'type', 'monthly_rent', 'status', 'description'
    ];

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function activeLease()
    {
        return $this->hasOne(Lease::class)->where('status', 'active');
    }

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function currentTenant()
    {
        $lease = $this->activeLease;
        return $lease ? $lease->tenant : null;
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'occupied' => '<span class="badge bg-success">Occupied</span>',
            'vacant' => '<span class="badge bg-warning text-dark">Vacant</span>',
            'maintenance' => '<span class="badge bg-danger">Maintenance</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'studio' => 'Studio',
            '1br' => '1 Bedroom',
            '2br' => '2 Bedrooms',
            '3br' => '3 Bedrooms',
            default => $this->type,
        };
    }
}
