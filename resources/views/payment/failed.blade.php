@extends('layouts.app')

@section('title', 'Pembayaran Gagal')

@section('styles')
    <link href="{{ asset('css/payment-result.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="payment-result-page failed">
        <div class="payment-result-bg payment-result-bg-1"></div>
        <div class="payment-result-bg payment-result-bg-2"></div>

        <div class="container position-relative z-index-1">
            <div class="payment-result-card" data-aos="zoom-in" data-aos-duration="850">
                <div class="payment-result-icon failed">
                    <i class="bi bi-x-circle"></i>
                </div>

                <span class="payment-result-badge failed">Pembayaran Gagal</span>

                <h1>
                    Maaf,
                    <span>pembayaran belum berhasil.</span>
                </h1>

                <p>
                    Pembayaran kamu belum dapat dikonfirmasi. Silakan coba kembali,
                    periksa koneksi internet, atau pilih metode pembayaran lain jika tersedia.
                </p>

                <div class="payment-result-summary">
                    <div>
                        <span>Kode Pesanan</span>
                        <strong>{{ $order->order_code }}</strong>
                    </div>

                    <div>
                        <span>Metode</span>
                        <strong>{{ strtoupper($order->payment?->payment_type ?? $order->payment?->method ?? 'MIDTRANS') }}</strong>
                    </div>

                    <div>
                        <span>Total Tagihan</span>
                        <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>

                    <div>
                        <span>Status</span>
                        <strong class="text-danger">{{ ucfirst($order->payment_status) }}</strong>
                    </div>
                </div>

                <div class="payment-result-note failed">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>
                        Jika saldo sudah terpotong tetapi status belum berubah, hubungi admin Triowash.
                    </span>
                </div>

                <div class="payment-result-actions">
                    <a href="{{ route('payment.pay', $order->order_code) }}" class="btn btn-primary btn-modern shadow-primary">
                        <i class="bi bi-arrow-repeat"></i>
                        Coba Bayar Lagi
                    </a>

                    <a href="{{ route('tracking.index') }}" class="btn btn-light btn-modern">
                        <i class="bi bi-search"></i>
                        Cek Pesanan
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection