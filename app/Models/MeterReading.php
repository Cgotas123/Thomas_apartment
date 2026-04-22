<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    protected $fillable = [
        'unit_id', 
        'type', 
        'previous_reading', 
        'current_reading', 
        'consumption', 
        'cost',
        'reading_date'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Rates constants (You can change these later)
    const ELECTRIC_RATE = 15.00; // ₱15 per kWh
    const WATER_RATE = 50.00;    // ₱50 per unit

    public static function calculateCost($type, $consumption)
    {
        if ($type === 'Electricity') {
            return $consumption * self::ELECTRIC_RATE;
        }
        return $consumption * self::WATER_RATE;
    }
}
