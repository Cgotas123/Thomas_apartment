<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['full_name', 'email', 'phone_number', 'emergency_contact', 'category', 'registration_date'];

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }
}
