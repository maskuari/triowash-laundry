@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('styles')
    <link href="{{ asset('css/payment-result.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="payment-result-page success">
        <div class="payment-result-bg payment-result-bg-1"></div>
        <div class="payment-result-bg payment-result-bg-2"></div>

        <div class="container position-relative z-index-1">
            <div class="payment-result-card" data-aos="zoom-in" data-aos-duration="850">
                <div class="payment-result-icon success">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <span class="payment-result-badge">Pembayaran Berhasil</span>

                <h1>
                    Terima kasih,
                    <span>pembayaran kamu berhasil.</span>
                </h1>

                <p>
                    Pembayaran untuk pesanan laundry kamu sudah dikonfirmasi.
                    Status pembayaran akan diperbarui menjadi lunas pada sistem Triowash.
                </p>

                <div class="payment-result-summary">
                    <div>
                        <span>Kode Pesanan</span>
                        <strong>TWO-001</strong>
                    </div>

                    <div>
                        <span>Metode</span>
                        <strong>QRIS</strong>
                    </div>

                    <div>
                        <span>Total Bayar</span>
                        <strong>Rp21.000</strong>
                    </div>

                    <div>
                        <span>Status</span>
                        <strong class="text-success">Paid</strong>
                    </div>
                </div>

                <div class="payment-result-note">
                    <i class="bi bi-info-circle"></i>
                    <span>
                        Simpan kode pesanan untuk memeriksa status laundry kamu secara berkala.
                    </span>
                </div>

                <div class="payment-result-actions">
                    <a href="/periksa-pesanan" class="btn btn-primary btn-modern shadow-primary">
                        <i class="bi bi-search"></i>
                        Cek Status Pesanan
                    </a>

                    <a href="/" class="btn btn-light btn-modern">
                        <i class="bi bi-house-door"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection