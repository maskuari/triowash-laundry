@extends('layouts.app')

@section('title', 'Pembayaran')

@section('styles')
    <link href="{{ asset('css/payment.css') }}" rel="stylesheet">
@endsection

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
                        Pilih metode
                        <span>pembayaranmu.</span>
                    </h1>

                    <p>
                        Total pembayaran muncul setelah cucian ditimbang oleh admin.
                        Kamu bisa memilih pembayaran QRIS atau tunai sesuai kondisi pemesanan.
                    </p>

                    <div class="payment-info-list">
                        <div class="payment-info-item">
                            <i class="bi bi-qr-code"></i>
                            <div>
                                <strong>QRIS</strong>
                                <span>Cocok untuk pelanggan jarak jauh.</span>
                            </div>
                        </div>

                        <div class="payment-info-item">
                            <i class="bi bi-cash-stack"></i>
                            <div>
                                <strong>Tunai</strong>
                                <span>Cocok untuk pelanggan walk-in atau bayar di toko.</span>
                            </div>
                        </div>

                        <div class="payment-info-item">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <strong>Transparan</strong>
                                <span>Total dihitung berdasarkan berat aktual.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right --}}
                <div class="payment-card" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="payment-card-header">
                        <div>
                            <span>Payment Detail</span>
                            <h2>Konfirmasi Pembayaran</h2>
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
                                    <strong>TWO-001</strong>
                                </div>

                                <small>Belum Dibayar</small>
                            </div>

                            <div class="payment-order-grid">
                                <div>
                                    <span>Nama</span>
                                    <strong>Budi Santoso</strong>
                                </div>

                                <div>
                                    <span>No. Telepon</span>
                                    <strong>081234567890</strong>
                                </div>

                                <div>
                                    <span>Layanan</span>
                                    <strong>Cuci Komplit</strong>
                                </div>

                                <div>
                                    <span>Berat</span>
                                    <strong>3.5 Kg</strong>
                                </div>
                            </div>

                            <div class="payment-total-box">
                                <span>Total Pembayaran</span>
                                <strong>Rp21.000</strong>
                            </div>
                        </div>

                        {{-- Method --}}
                        <div class="payment-method-section">
                            <h5>Pilih Metode Pembayaran</h5>

                            <div class="payment-method-grid">
                                <button type="button" class="payment-method active" data-method="qris">
                                    <i class="bi bi-qr-code"></i>
                                    <div>
                                        <strong>QRIS</strong>
                                        <span>Scan QR untuk membayar</span>
                                    </div>
                                </button>

                                <button type="button" class="payment-method" data-method="cash">
                                    <i class="bi bi-cash-stack"></i>
                                    <div>
                                        <strong>Tunai</strong>
                                        <span>Bayar langsung ke admin</span>
                                    </div>
                                </button>
                            </div>
                        </div>

                        {{-- QRIS Content --}}
                        <div class="payment-content active" id="qrisContent">
                            <div class="qris-card">
                                <div class="qris-box">
                                    <div class="qris-placeholder">
                                        <i class="bi bi-qr-code"></i>
                                    </div>
                                </div>

                                <div class="qris-info">
                                    <h5>Scan QRIS untuk membayar</h5>
                                    <p>
                                        Buka aplikasi pembayaran atau mobile banking, lalu scan kode QRIS ini.
                                        Setelah pembayaran berhasil, klik tombol konfirmasi.
                                    </p>
                                </div>
                            </div>

                            <a href="/pembayaran/sukses" class="payment-confirm-btn text-decoration-none">
                                <i class="bi bi-check-circle"></i>
                                Saya Sudah Bayar QRIS
                            </a>
                            <a href="/pembayaran/gagal" class="payment-failed-link">
                                Simulasikan pembayaran gagal
                            </a>
                        </div>

                        {{-- Cash Content --}}
                        <div class="payment-content" id="cashContent">
                            <div class="cash-card">
                                <div class="cash-icon">
                                    <i class="bi bi-cash-coin"></i>
                                </div>

                                <div>
                                    <h5>Pembayaran Tunai</h5>
                                    <p>
                                        Pilih metode tunai jika pelanggan membayar langsung di toko
                                        atau saat pesanan diterima. Admin akan mengonfirmasi pembayaran.
                                    </p>
                                </div>
                            </div>

                            <div class="cash-input-box">
                                <label>Nominal Uang Diterima</label>
                                <div>
                                    <span>Rp</span>
                                    <input type="number" placeholder="Contoh: 25000">
                                </div>
                            </div>

                            <div class="cash-change-box">
                                <span>Estimasi Kembalian</span>
                                <strong>Rp4.000</strong>
                            </div>

                            <button type="button" class="payment-confirm-btn">
                                <i class="bi bi-check-circle"></i>
                                Konfirmasi Pembayaran Tunai
                            </button>
                        </div>

                        <a href="/periksa-pesanan" class="payment-back-link">
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
    <script>
        const methodButtons = document.querySelectorAll('.payment-method');
        const qrisContent = document.getElementById('qrisContent');
        const cashContent = document.getElementById('cashContent');

        methodButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const method = button.dataset.method;

                methodButtons.forEach((item) => item.classList.remove('active'));
                button.classList.add('active');

                qrisContent.classList.remove('active');
                cashContent.classList.remove('active');

                if (method === 'qris') {
                    qrisContent.classList.add('active');
                }

                if (method === 'cash') {
                    cashContent.classList.add('active');
                }
            });
        });
    </script>
@endsection