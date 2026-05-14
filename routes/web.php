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

// Pesan Laundry Page
Route::view('/pesan', 'order.order')->name('order');

// Admin Dashboard
Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');

// Tracking Pesanan
Route::view('/periksa-pesanan', 'tracking.index')->name('tracking.index');

// Pembayaran
// Pembayaran
Route::view('/pembayaran', 'payment.index')->name('payment.index');
Route::view('/pembayaran/sukses', 'payment.success')->name('payment.success');
Route::view('/pembayaran/gagal', 'payment.failed')->name('payment.failed');