<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiCustomerServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransController;

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
Route::get('/pesan/sukses/{order:order_code}', [OrderController::class, 'success'])
    ->name('order.success');

// Tracking Pesanan
Route::get('/periksa-pesanan', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/periksa-pesanan', [TrackingController::class, 'search'])->name('tracking.search');

// Admin Dashboard
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::patch('/admin/pesanan/terima-semua', [AdminController::class, 'approveAllIncomingOrders'])
    ->name('admin.orders.approve-all');

Route::delete('/admin/pesanan/tolak-semua', [AdminController::class, 'rejectAllIncomingOrders'])
    ->name('admin.orders.reject-all');

Route::patch('/admin/toko/status', [AdminController::class, 'updateStoreStatus'])
    ->name('admin.store-status.update');

Route::get('/admin/pesanan/{order:order_code}', [AdminController::class, 'showOrder'])
    ->name('admin.orders.show');

Route::patch('/admin/pesanan/{order:order_code}/acc', [AdminController::class, 'approveOrder'])
    ->name('admin.orders.approve');

Route::patch('/admin/pesanan/{order:order_code}/tolak', [AdminController::class, 'rejectOrder'])
    ->name('admin.orders.reject');

Route::patch('/admin/pesanan/{order:order_code}/timbang', [AdminController::class, 'updateWeight'])
    ->name('admin.orders.weight');

Route::patch('/admin/pesanan/{order:order_code}/status', [AdminController::class, 'updateStatus'])
    ->name('admin.orders.status');

Route::post('/admin/pesanan/{order:order_code}/bayar-tunai', [AdminController::class, 'confirmCashPayment'])
    ->name('admin.orders.cash-payment');

Route::delete('/admin/pesanan/{order:order_code}', [AdminController::class, 'deleteOrder'])
    ->name('admin.orders.delete');

// Admin Layanan, Paket, Wangi
Route::post('/admin/layanan', [AdminController::class, 'storeService'])
    ->name('admin.services.store');

Route::patch('/admin/layanan/{service}', [AdminController::class, 'updateService'])
    ->name('admin.services.update');

Route::delete('/admin/layanan/{service}', [AdminController::class, 'deleteService'])
    ->name('admin.services.delete');

// Admin Opsi Antar Jemput
Route::post('/admin/opsi-antar-jemput', [AdminController::class, 'storePickupOption'])
    ->name('admin.pickup-options.store');

Route::patch('/admin/opsi-antar-jemput/{pickupOption}', [AdminController::class, 'updatePickupOption'])
    ->name('admin.pickup-options.update');

Route::delete('/admin/opsi-antar-jemput/{pickupOption}', [AdminController::class, 'deletePickupOption'])
    ->name('admin.pickup-options.delete');

// Pembayaran
Route::get('/pembayaran/{order:order_code}', [MidtransController::class, 'pay'])
    ->name('payment.pay');

Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');

Route::view('/pembayaran/sukses', 'payment.success')->name('payment.success');
Route::view('/pembayaran/gagal', 'payment.failed')->name('payment.failed');