<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_chat_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('provider')->default('local');
            $table->string('intent')->nullable();
            $table->decimal('confidence', 5, 2)->default(0);
            $table->text('user_message');
            $table->text('ai_reply')->nullable();
            $table->boolean('is_success')->default(false);
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index('session_id');
            $table->index('provider');
            $table->index('intent');
            $table->index('is_success');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_chat_logs');
    }
};