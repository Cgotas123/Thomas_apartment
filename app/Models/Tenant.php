<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
        'emergency_contact', 'emergency_contact_phone',
        'date_of_birth', 'id_type', 'id_number', 'address', 'photo'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function activeLease()
    {
        return $this->hasOne(Lease::class)->where('status', 'active');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getCurrentUnitAttribute()
    {
        $lease = $this->activeLease;
        return $lease ? $lease->unit : null;
    }
}
