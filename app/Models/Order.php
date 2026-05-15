<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    public const STATUS_DIJEMPUT = 'dijemput';
    public const STATUS_DIPROSES = 'diproses';
    public const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_DIANTAR = 'diantar';
    public const STATUS_SELESAI_DITERIMA = 'selesai_diterima';
    public const STATUS_DIBATALKAN = 'dibatalkan';

    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PAID = 'paid';

    protected $fillable = [
        'customer_id',
        'order_code',
        'pickup_type',
        'pickup_option_id',
        'pickup_option_name',
        'status',
        'payment_status',
        'weight',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'total_price' => 'integer',
    ];

    public static function generateOrderCode(): string
    {
        $lastOrder = self::query()->latest('id')->first();
        $nextNumber = $lastOrder ? $lastOrder->id + 1 : 1;

        return 'TWO-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function legacyPickupTypes(): array
    {
        return [
            'dijemput_antar',
            'dijemput_saja',
            'diantar_saja',
            'antar_ambil_sendiri',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function pickupOption(): BelongsTo
    {
        return $this->belongsTo(PickupOption::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items(): HasMany
    {
        return $this->orderItems();
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(StatusLog::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_DIJEMPUT => 'Dijemput',
            self::STATUS_DIPROSES => 'Diproses',
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIANTAR => 'Diantar',
            self::STATUS_SELESAI_DITERIMA => 'Selesai Diterima',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            self::PAYMENT_PAID => 'Sudah Dibayar',
            self::PAYMENT_UNPAID => 'Belum Dibayar',
            default => 'Tidak Diketahui',
        };
    }
}