<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public const METHOD_QRIS = 'qris';
    public const METHOD_CASH = 'cash';

    public const STATUS_UNPAID = 'unpaid';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'order_id',
        'payment_code',
        'method',
        'status',
        'amount',
        'cash_received',
        'change_amount',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'integer',
        'cash_received' => 'integer',
        'change_amount' => 'integer',
        'paid_at' => 'datetime',
    ];

    public static function generatePaymentCode(): string
    {
        $lastPayment = self::query()->latest('id')->first();
        $nextNumber = $lastPayment ? $lastPayment->id + 1 : 1;

        return 'PAY-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}