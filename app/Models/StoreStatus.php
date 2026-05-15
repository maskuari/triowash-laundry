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
}