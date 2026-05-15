<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreStatus extends Model
{
    protected $fillable = [
        'is_open',
        'status_note',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];

    public function getLabelAttribute(): string
    {
        return $this->is_open ? 'Buka' : 'Tutup';
    }

    public function getPickupHoursLabelAttribute(): string
    {
        return '08:00 - 17:00 WITA';
    }

    public function getLaundryHoursLabelAttribute(): string
    {
        return '07:00 - 21:30 WITA';
    }
}