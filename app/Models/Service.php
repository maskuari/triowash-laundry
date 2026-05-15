<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    public const CATEGORY_PAKET = 'paket';
    public const CATEGORY_LAYANAN = 'layanan';
    public const CATEGORY_WANGI = 'wangi';

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
        return $query->where('category', self::CATEGORY_PAKET);
    }

    public function scopeServiceType($query)
    {
        return $query->where('category', self::CATEGORY_LAYANAN);
    }

    public function scopeFragrance($query)
    {
        return $query->where('category', self::CATEGORY_WANGI);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            self::CATEGORY_PAKET => 'Paket',
            self::CATEGORY_LAYANAN => 'Layanan',
            self::CATEGORY_WANGI => 'Wangi',
            default => ucfirst((string) $this->category),
        };
    }

    public function getIconClassAttribute(): string
    {
        return match ($this->category) {
            self::CATEGORY_PAKET => 'bi-basket3',
            self::CATEGORY_LAYANAN => 'bi-lightning-charge',
            self::CATEGORY_WANGI => 'bi-stars',
            default => 'bi-basket3',
        };
    }
}