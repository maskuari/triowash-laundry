<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE payments MODIFY method ENUM('qris', 'cash', 'midtrans') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY method ENUM('qris', 'cash') NOT NULL");
    }
};