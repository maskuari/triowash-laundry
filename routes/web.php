<?php

use App\Http\Controllers\AiCustomerServiceController;
use Illuminate\Support\Facades\Route;

// Home
Route::view('/', 'home.home')->name('home');

// AI Customer Service Page
Route::view('/cs-ai', 'ai.csai')->name('csai');

// AI Customer Service Backend
Route::post('/cs-ai/chat', [AiCustomerServiceController::class, 'chat'])
    ->name('csai.chat');