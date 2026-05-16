@extends('layouts.app')

@section('title', 'Pembayaran')

@section('styles')
    <link href="{{ asset('css/payment.css') }}" rel="stylesheet">

    @if ($isProduction)
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @endif
@endsection

@php
    $mainService = $order?->orderItems?->firstWhere('service.category', 'paket')?->service;
    $serviceType = $order?->orderItems?->firstWhere('service.category', 'layanan')?->service;
    $fragrance = $order?->orderItems?->firstWhere('service.category', 'wangi')?->service;
@endphp

@section('content')
    <section class="payment-page">
        <div class="payment-bg payment-bg-1"></div>
        <div class="payment-bg payment-bg-2"></div>

        <div class="container position-relative z-index-1">
            <div class="payment-layout">
                {{-- Left --}}
                <div class="payment-intro" data-aos="fade-right" data-aos-duration="900">
                    <div class="payment-badge">
                        <i class="bi bi-credit-card"></i>
                        Pembayaran Triowash
                    </div>

                    <h1>
                        Selesaikan
                        <span>pembayaranmu.</span>
                    </h1>

                    <p>
                        Total pembayaran muncul setelah cucian ditimbang oleh admin.
                        Klik tombol Bayar Sekarang untuk melanjutkan pembayaran melalui Midtrans.
                    </p>

                    <div class="payment-info-list">
                        <div class="payment-info-item">
                            <i class="bi bi-credit-card-2-front"></i>
                            <div>
                                <strong>Midtrans</strong>
                                <span>Bisa bayar lewat QRIS, e-wallet, virtual account, dan metode lain yang tersedia.</span>
                            </div>
                        </div>

                        <div class="payment-info-item">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <strong>Aman</strong>
                                <span>Pembayaran diproses langsung oleh Midtrans.</span>
                            </div>
                        </div>

                        <div class="payment-info-item">
                            <i class="bi bi-receipt"></i>
                            <div>
                                <strong>Otomatis</strong>
                                <span>Status pembayaran akan diperbarui otomatis setelah pembayaran berhasil.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right --}}
                <div class="payment-card" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="payment-card-header">
                        <div>
                            <span>Payment Detail</span>
                            <h2>Detail Pembayaran</h2>
                        </div>

                        <div class="payment-header-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>

                    <div class="payment-body">
                        {{-- Order Summary --}}
                        <div class="payment-order-card">
                            <div class="payment-order-top">
                                <div>
                                    <span>Kode Pesanan</span>
                                    <strong>{{ $order->order_code }}</strong>
                                </div>

                                <small>{{ $order->payment_status_label }}</small>
                            </div>

                            <div class="payment-order-grid">
                                <div>
                                    <span>Nama</span>
                                    <strong>{{ $order->customer->name }}</strong>
                                </div>

                                <div>
                                    <span>No. Telepon</span>
                                    <strong>{{ $order->customer->phone }}</strong>
                                </div>

                                <div>
                                    <span>Paket</span>
                                    <strong>{{ $mainService?->service_name ?? '-' }}</strong>
                                </div>

                                <div>
                                    <span>Layanan</span>
                                    <strong>{{ $serviceType?->service_name ?? '-' }}</strong>
                                </div>

                                <div>
                                    <span>Wangi</span>
                                    <strong>{{ $fragrance?->service_name ?? '-' }}</strong>
                                </div>

                                <div>
                                    <span>Berat</span>
                                    <strong>{{ $order->weight ? $order->weight . ' Kg' : 'Belum ditimbang' }}</strong>
                                </div>
                            </div>

                            <div class="payment-total-box">
                                <span>Total Pembayaran</span>
                                <strong>
                                    @if ($order->total_price > 0)
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                    @else
                                        Belum dihitung
                                    @endif
                                </strong>
                            </div>
                        </div>

                        @if ($order->payment_status === \App\Models\Order::PAYMENT_PAID)
                            <div class="cash-card">
                                <div class="cash-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>

                                <div>
                                    <h5>Pembayaran Sudah Berhasil</h5>
                                    <p>
                                        Pesanan ini sudah dibayar. Kamu bisa kembali ke halaman Periksa Pesanan
                                        untuk melihat status laundry.
                                    </p>
                                </div>
                            </div>
                        @elseif ($order->total_price <= 0)
                            <div class="cash-card">
                                <div class="cash-icon">
                                    <i class="bi bi-clock"></i>
                                </div>

                                <div>
                                    <h5>Menunggu Total Pembayaran</h5>
                                    <p>
                                        Total pembayaran belum tersedia. Silakan tunggu admin menimbang cucian
                                        dan menghitung total harga terlebih dahulu.
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- Midtrans Content --}}
                            <div class="payment-content active" id="midtransContent">
                                <div class="qris-card">
                                    <div class="qris-box">
                                        <div class="qris-placeholder">
                                            <i class="bi bi-credit-card"></i>
                                        </div>
                                    </div>

                                    <div class="qris-info">
                                        <h5>Bayar melalui Midtrans</h5>
                                        <p>
                                            Klik tombol di bawah ini. Nanti akan muncul popup pembayaran Midtrans.
                                            Pilih metode pembayaran yang tersedia, lalu selesaikan pembayaran.
                                        </p>
                                    </div>
                                </div>

                                <button type="button" id="pay-button" class="payment-confirm-btn">
                                    <i class="bi bi-credit-card"></i>
                                    Bayar Sekarang
                                </button>

                                <a href="{{ route('payment.failed') }}" class="payment-failed-link">
                                    Batalkan pembayaran
                                </a>
                            </div>
                        @endif

                        <a href="{{ route('tracking.index') }}" class="payment-back-link">
                            <i class="bi bi-arrow-left"></i>
                            Kembali ke Periksa Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @if (
        $order->payment_status === \App\Models\Order::PAYMENT_UNPAID &&
        $order->total_price > 0
    )
        <script>
            const payButton = document.getElementById('pay-button');

            payButton?.addEventListener('click', function () {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function () {
                        window.location.href = '{{ route('payment.success') }}';
                    },
                    onPending: function () {
                        alert('Pembayaran masih pending. Silakan selesaikan pembayaran.');
                        window.location.href = '{{ route('tracking.index') }}';
                    },
                    onError: function () {
                        window.location.href = '{{ route('payment.failed') }}';
                    },
                    onClose: function () {
                        alert('Popup pembayaran ditutup. Kamu bisa klik Bayar Sekarang lagi untuk melanjutkan.');
                    }
                });
            });
        </script>
    @endif
@endsection