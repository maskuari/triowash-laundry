<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiChatLog extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'provider',
        'intent',
        'confidence',
        'user_message',
        'ai_reply',
        'is_success',
        'error_message',
    ];

    protected $casts = [
        'confidence' => 'float',
        'is_success' => 'boolean',
    ];
}