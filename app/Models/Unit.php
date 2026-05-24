<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['unit_number', 'floor', 'unit_type_id', 'type', 'base_rent', 'status', 'water_meter', 'electric_meter'];

    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }

    public function activeLease()
    {
        return $this->hasOne(Lease::class)->where('active', true);
    }
}
