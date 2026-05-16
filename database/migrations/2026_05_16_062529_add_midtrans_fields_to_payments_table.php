<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('payment_code');
            $table->string('midtrans_order_id')->nullable()->after('snap_token');
            $table->string('transaction_id')->nullable()->after('midtrans_order_id');
            $table->string('payment_type')->nullable()->after('transaction_id');
            $table->string('fraud_status')->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'midtrans_order_id',
                'transaction_id',
                'payment_type',
                'fraud_status',
            ]);
        });
    }
};