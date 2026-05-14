<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'service_name',
        'category',
        'price_per_kg',
    ];

    protected $casts = [
        'price_per_kg' => 'integer',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePackage($query)
    {
        return $query->where('category', 'paket');
    }

    public function scopeFragrance($query)
    {
        return $query->where('category', 'wangi');
    }
}