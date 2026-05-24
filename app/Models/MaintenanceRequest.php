<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id', 'title', 'description', 'priority', 'status',
        'reported_by', 'completed_at', 'completion_notes'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning text-dark">Pending</span>',
            'in_progress' => '<span class="badge bg-info">In Progress</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelled</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getPriorityBadgeAttribute()
    {
        return match($this->priority) {
            'low' => '<span class="badge bg-secondary">Low</span>',
            'medium' => '<span class="badge bg-info">Medium</span>',
            'high' => '<span class="badge bg-warning text-dark">High</span>',
            'urgent' => '<span class="badge bg-danger">Urgent</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
