<?php

return [
    'email' => env('ADMIN_EMAIL', 'triowash@admin.co.id'),
    'password_hash' => env('ADMIN_PASSWORD_HASH'),
    'session_key' => 'triowash_admin_authenticated',
    'session_email_key' => 'triowash_admin_email',
];
