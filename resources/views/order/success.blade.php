@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('styles')
    <link href="{{ asset('css/order-success.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="order-success-page">
        <div class="container">
            <div class="order-success-card" data-aos="fade-up" data-aos-duration="700">
                <div class="order-success-top">
                    <div class="order-success-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <div>
                        <span class="order-success-badge">Pesanan Berhasil Dibuat</span>
                        <h1>Pesanan menunggu verifikasi admin.</h1>
                        <p>
                            Simpan kode pesanan ini untuk mengecek status laundry kamu.
                            Admin akan memverifikasi pesanan sebelum proses penjemputan atau pengerjaan dimulai.
                        </p>
                    </div>
                </div>

                <div class="order-code-box">
                    <span>Kode Pesanan</span>
                    <strong>{{ $order->order_code }}</strong>

                    <button type="button" id="copyOrderCode" data-code="{{ $order->order_code }}">
                        <i class="bi bi-clipboard"></i>
                        Salin Kode
                    </button>
                </div>

                <div class="order-success-info">
                    <div>
                        <span>Nama</span>
                        <strong>{{ $order->customer->name }}</strong>
                    </div>

                    <div>
                        <span>No. Telepon</span>
                        <strong>{{ $order->customer->phone }}</strong>
                    </div>

                    <div>
                        <span>Status Pesanan</span>
                        <strong>{{ $order->status_label }}</strong>
                    </div>

                    <div>
                        <span>Pembayaran</span>
                        <strong>{{ $order->payment_status_label }}</strong>
                    </div>
                </div>

                <div class="order-success-note">
                    <i class="bi bi-info-circle"></i>
                    <p>
                        Gunakan kode pesanan di halaman Periksa Pesanan untuk memantau status laundry kamu.
                    </p>
                </div>

                <div class="order-success-actions">
                    <a href="/periksa-pesanan" class="btn btn-primary btn-modern shadow-primary">
                        <i class="bi bi-search"></i>
                        Cek Status
                    </a>

                    <a href="/pesan" class="btn btn-light btn-modern">
                        <i class="bi bi-plus-circle"></i>
                        Pesan Lagi
                    </a>

                    <a href="/" class="order-home-link">
                        <i class="bi bi-house-door"></i>
                        Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const copyButton = document.getElementById('copyOrderCode');

        copyButton?.addEventListener('click', async () => {
            const code = copyButton.dataset.code;

            try {
                await navigator.clipboard.writeText(code);
                copyButton.innerHTML = '<i class="bi bi-check2"></i> Tersalin';
            } catch (error) {
                copyButton.innerHTML = '<i class="bi bi-check2"></i> {{ $order->order_code }}';
            }

            setTimeout(() => {
                copyButton.innerHTML = '<i class="bi bi-clipboard"></i> Salin Kode';
            }, 1600);
        });
    </script>
@endsection