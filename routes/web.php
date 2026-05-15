<?php

use App\Http\Controllers\AiCustomerServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// AI Customer Service Page
Route::view('/cs-ai', 'ai.csai')->name('csai');

// AI Customer Service Backend
Route::post('/cs-ai/chat', [AiCustomerServiceController::class, 'chat'])
    ->name('csai.chat');

// Pesan Laundry
Route::get('/pesan', [OrderController::class, 'create'])->name('order.create');
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
Route::get('/pesan/sukses/{order:order_code}', [OrderController::class, 'success'])->name('order.success');

// Admin Dashboard
Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');

// Tracking Pesanan
Route::view('/periksa-pesanan', 'tracking.index')->name('tracking.index');

// Pembayaran
Route::view('/pembayaran', 'payment.index')->name('payment.index');
Route::view('/pembayaran/sukses', 'payment.success')->name('payment.success');
Route::view('/pembayaran/gagal', 'payment.failed')->name('payment.failed');