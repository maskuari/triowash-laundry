@extends('layouts.app')

@section('title', 'Periksa Pesanan')

@section('styles')
    <link href="{{ asset('css/tracking.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="tracking-page">
        <div class="tracking-bg tracking-bg-1"></div>
        <div class="tracking-bg tracking-bg-2"></div>

        <div class="container position-relative z-index-1">
            <div class="tracking-layout">
                {{-- Form --}}
                <div class="tracking-hero" data-aos="fade-right" data-aos-duration="900">
                    <div class="tracking-badge">
                        <i class="bi bi-search-heart"></i>
                        Periksa Pesanan
                    </div>

                    <h1>
                        Cek status laundry
                        <span>tanpa login.</span>
                    </h1>

                    <p>
                        Masukkan nama dan nomor telepon yang digunakan saat pemesanan.
                        Sistem akan menampilkan status terbaru pesanan laundry kamu.
                    </p>

                    <form class="tracking-form" id="trackingForm">
                        <div class="tracking-field">
                            <i class="bi bi-person"></i>
                            <input type="text" id="customerName" placeholder="Contoh: Budi Santoso" autocomplete="off">
                        </div>

                        <div class="tracking-field">
                            <i class="bi bi-telephone"></i>
                            <input type="text" id="customerPhone" placeholder="Contoh: 081234567890" autocomplete="off">
                        </div>

                        <button type="submit">
                            <i class="bi bi-search"></i>
                            Cek Pesanan
                        </button>
                    </form>
                </div>

                {{-- Result --}}
                <div class="tracking-card" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="tracking-card-head">
                        <div>
                            <span>Tracking Order</span>
                            <h2>Detail Pesanan</h2>
                        </div>

                        <div class="tracking-head-icon">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                    </div>

                    <div class="tracking-result" id="trackingResult">
                        <div class="tracking-order">
                            <div>
                                <span>Kode Pesanan</span>
                                <strong>TWO-001</strong>
                            </div>

                            <small>Diproses</small>
                        </div>

                        <div class="tracking-data">
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
                                <span>Total Harga</span>
                                <strong>Rp21.000</strong>
                            </div>
                        </div>

                        <div class="tracking-title">
                            <i class="bi bi-arrow-repeat"></i>
                            Progress Pesanan
                        </div>

                        <div class="tracking-timeline">
                            <div class="tracking-step done">
                                <i class="bi bi-check-lg"></i>
                                <div>
                                    <strong>Verifikasi</strong>
                                    <span>Pesanan masuk dan diterima admin.</span>
                                </div>
                            </div>

                            <div class="tracking-step done">
                                <i class="bi bi-check-lg"></i>
                                <div>
                                    <strong>Dijemput</strong>
                                    <span>Kurir menjemput cucian pelanggan.</span>
                                </div>
                            </div>

                            <div class="tracking-step current">
                                <i class="bi bi-droplet-half"></i>
                                <div>
                                    <strong>Diproses</strong>
                                    <span>Pakaian sedang dicuci atau dikerjakan.</span>
                                </div>
                            </div>

                            <div class="tracking-step">
                                <i class="bi bi-box-seam"></i>
                                <div>
                                    <strong>Selesai</strong>
                                    <span>Pengerjaan selesai.</span>
                                </div>
                            </div>

                            <div class="tracking-step">
                                <i class="bi bi-truck"></i>
                                <div>
                                    <strong>Diantar</strong>
                                    <span>Pesanan dalam pengantaran.</span>
                                </div>
                            </div>

                            <div class="tracking-step">
                                <i class="bi bi-house-check"></i>
                                <div>
                                    <strong>Diterima</strong>
                                    <span>Pesanan sudah diterima pelanggan.</span>
                                </div>
                            </div>
                        </div>

                        <div class="tracking-payment">
                            <div>
                                <span>Status Pembayaran</span>
                                <strong>Belum Dibayar</strong>
                            </div>

                            <a href="/pembayaran" class="tracking-pay-link">
                                <i class="bi bi-qr-code"></i>
                                Bayar
                            </a>
                        </div>
                    </div>

                    <div class="tracking-empty d-none" id="trackingEmpty">
                        <div class="tracking-empty-icon">
                            <i class="bi bi-search"></i>
                        </div>

                        <h5>Pesanan Tidak Ditemukan</h5>
                        <p>
                            Tidak ditemukan pesanan dengan nama dan nomor tersebut.
                            Pastikan data yang dimasukkan sudah benar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const trackingForm = document.getElementById('trackingForm');
        const trackingResult = document.getElementById('trackingResult');
        const trackingEmpty = document.getElementById('trackingEmpty');

        trackingForm?.addEventListener('submit', function (event) {
            event.preventDefault();

            const name = document.getElementById('customerName').value.trim();
            const phone = document.getElementById('customerPhone').value.trim();

            if (!name || !phone) {
                trackingResult.classList.add('d-none');
                trackingEmpty.classList.remove('d-none');
                return;
            }

            trackingEmpty.classList.add('d-none');
            trackingResult.classList.remove('d-none');
        });
    </script>
@endsection