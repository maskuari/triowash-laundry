<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->string('payment_code')->unique();

            $table->enum('method', ['qris', 'cash']);
            $table->enum('status', ['unpaid', 'paid', 'failed'])->default('unpaid');

            $table->unsignedInteger('amount')->default(0);
            $table->unsignedInteger('cash_received')->nullable();
            $table->unsignedInteger('change_amount')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('method');
            $table->index('status');
            $table->index('paid_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};