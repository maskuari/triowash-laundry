<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'pickup_option_id')) {
                $table->foreignId('pickup_option_id')
                    ->nullable()
                    ->after('pickup_type')
                    ->constrained('pickup_options')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('orders', 'pickup_option_name')) {
                $table->string('pickup_option_name')->nullable()->after('pickup_option_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'pickup_option_id')) {
                $table->dropConstrainedForeignId('pickup_option_id');
            }

            if (Schema::hasColumn('orders', 'pickup_option_name')) {
                $table->dropColumn('pickup_option_name');
            }
        });
    }
};