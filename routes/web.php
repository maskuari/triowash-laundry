<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AiCustomerServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MidtransController;
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
Route::get('/pesan/sukses/{order:order_code}', [OrderController::class, 'success'])
    ->name('order.success');

// Tracking Pesanan
Route::get('/periksa-pesanan', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/periksa-pesanan', [TrackingController::class, 'search'])->name('tracking.search');

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::post('/pesanan/manual', [AdminController::class, 'storeManualOrder'])
    ->name('admin.orders.manual-store');

    Route::patch('/pesanan/terima-semua', [AdminController::class, 'approveAllIncomingOrders'])
        ->name('admin.orders.approve-all');

    Route::delete('/pesanan/tolak-semua', [AdminController::class, 'rejectAllIncomingOrders'])
        ->name('admin.orders.reject-all');

    Route::patch('/toko/status', [AdminController::class, 'updateStoreStatus'])
        ->name('admin.store-status.update');

    Route::get('/pesanan/{order:order_code}', [AdminController::class, 'showOrder'])
        ->name('admin.orders.show');

    Route::patch('/pesanan/{order:order_code}/acc', [AdminController::class, 'approveOrder'])
        ->name('admin.orders.approve');

    Route::patch('/pesanan/{order:order_code}/tolak', [AdminController::class, 'rejectOrder'])
        ->name('admin.orders.reject');

    Route::patch('/pesanan/{order:order_code}/timbang', [AdminController::class, 'updateWeight'])
        ->name('admin.orders.weight');

    Route::patch('/pesanan/{order:order_code}/status', [AdminController::class, 'updateStatus'])
        ->name('admin.orders.status');

    Route::post('/pesanan/{order:order_code}/bayar-tunai', [AdminController::class, 'confirmCashPayment'])
        ->name('admin.orders.cash-payment');

    Route::delete('/pesanan/{order:order_code}', [AdminController::class, 'deleteOrder'])
        ->name('admin.orders.delete');

    // Admin Layanan, Paket, Wangi
    Route::post('/layanan', [AdminController::class, 'storeService'])
        ->name('admin.services.store');

    Route::patch('/layanan/{service}', [AdminController::class, 'updateService'])
        ->name('admin.services.update');

    Route::delete('/layanan/{service}', [AdminController::class, 'deleteService'])
        ->name('admin.services.delete');

    // Admin Opsi Antar Jemput
    Route::post('/opsi-antar-jemput', [AdminController::class, 'storePickupOption'])
        ->name('admin.pickup-options.store');

    Route::patch('/opsi-antar-jemput/{pickupOption}', [AdminController::class, 'updatePickupOption'])
        ->name('admin.pickup-options.update');

    Route::delete('/opsi-antar-jemput/{pickupOption}', [AdminController::class, 'deletePickupOption'])
        ->name('admin.pickup-options.delete');
});

// Pembayaran
Route::get('/pembayaran/{order:order_code}', [MidtransController::class, 'pay'])
    ->name('payment.pay');

Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');

Route::post('/pembayaran/{order:order_code}/simulasi-berhasil', [MidtransController::class, 'simulateSuccess'])
    ->name('payment.simulate-success');

Route::get('/pembayaran/sukses/{order:order_code}', [MidtransController::class, 'success'])
    ->name('payment.success');

Route::get('/pembayaran/gagal/{order:order_code}', [MidtransController::class, 'failed'])
    ->name('payment.failed');
