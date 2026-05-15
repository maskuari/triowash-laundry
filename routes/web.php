<?php

use App\Http\Controllers\AiCustomerServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackingController;
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

// Tracking Pesanan
Route::get('/periksa-pesanan', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/periksa-pesanan', [TrackingController::class, 'search'])->name('tracking.search');

// Admin Dashboard
Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');

// Pembayaran
Route::view('/pembayaran', 'payment.index')->name('payment.index');
Route::view('/pembayaran/sukses', 'payment.success')->name('payment.success');
Route::view('/pembayaran/gagal', 'payment.failed')->name('payment.failed');