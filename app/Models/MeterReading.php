<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id', 'type', 'previous_reading', 'current_reading',
        'consumption', 'rate_per_unit', 'reading_date', 'recorded_by'
    ];

    protected $casts = [
        'reading_date' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function getTotalAmountAttribute()
    {
        return $this->consumption * $this->rate_per_unit;
    }

    public function getTypeBadgeAttribute()
    {
        return match($this->type) {
            'water' => '<span class="badge bg-info">Water</span>',
            'electricity' => '<span class="badge bg-warning text-dark">Electricity</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
