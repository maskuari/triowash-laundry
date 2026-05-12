<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('order_code')->unique();

            $table->enum('pickup_type', [
                'dijemput_antar',
                'dijemput_saja',
                'diantar_saja',
                'antar_ambil_sendiri'
            ]);

            $table->enum('status', [
                'menunggu_verifikasi',
                'dijemput',
                'diproses',
                'menunggu_pembayaran',
                'selesai',
                'diantar',
                'selesai_diterima',
                'dibatalkan'
            ])->default('menunggu_verifikasi');

            $table->enum('payment_status', [
                'unpaid',
                'paid'
            ])->default('unpaid');

            $table->decimal('weight', 8, 2)->nullable();

            $table->integer('total_price')->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
