@extends('layouts.app')

@section('title', 'Layanan Antar Jemput Praktis')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- Hero --}}
    <section class="home-hero">
        <div class="home-hero-orb home-hero-orb-1"></div>
        <div class="home-hero-orb home-hero-orb-2"></div>

        <div class="container position-relative z-index-1">
            <div class="row align-items-center home-hero-row">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <div class="home-hero-content">
                        <div class="home-hero-badge">
                            <i class="bi bi-stars"></i>
                            Promo Member Baru: Diskon 10%
                        </div>

                        {{-- Mobile Image --}}
                        <div class="home-mobile-visual">
                            <img src="{{ asset('assets/images/baju.png') }}" alt="Triowash Laundry Service"
                                class="home-hero-image">
                        </div>

                        <h1 class="home-hero-title">
                            <span>Triowash Laundry</span>
                            <strong>Layanan Praktis.</strong>
                        </h1>

                        <p class="home-hero-description">
                            Antar jemput gratis untuk wilayah Banjarmasin. Cuci bersih, wangi, dan rapi tanpa perlu keluar
                            rumah.
                            Sistem bayar di akhir yang aman dan transparan.
                        </p>

                        <div class="home-hero-actions">
                            <a href="/pesan" class="btn btn-primary btn-hero shadow-primary">
                                <i class="bi bi-bag-heart"></i>
                                Pesan Sekarang
                            </a>

                            <a href="/periksa-pesanan" class="btn btn-light btn-hero btn-hero-secondary">
                                <i class="bi bi-search"></i>
                                Periksa Pesanan
                            </a>
                        </div>

                        <div class="home-stats">
                            <div class="home-stat-card">
                                <i class="bi bi-truck home-stat-icon"></i>
                                <strong>Gratis</strong>
                                <span>Antar Jemput</span>
                            </div>

                            <div class="home-stat-card">
                                <i class="bi bi-grid-1x2 home-stat-icon home-stat-icon-blue"></i>
                                <strong>3+</strong>
                                <span>Pilihan Layanan</span>
                            </div>

                            <div class="home-stat-card">
                                <i class="bi bi-lightning-charge home-stat-icon home-stat-icon-purple"></i>
                                <strong>Fast</strong>
                                <span>Proses Cepat</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Desktop Image --}}
                <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="home-visual">
                        <div class="home-visual-glow"></div>

                        <img src="{{ asset('assets/images/baju.png') }}" alt="Triowash Laundry Service"
                            class="home-hero-image">

                        <div class="home-floating-card">
                            <div class="home-floating-icon">
                                <i class="bi bi-droplet-half"></i>
                            </div>

                            <div>
                                <h6>Bersih & Wangi</h6>
                                <span>Siap dipakai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Layanan --}}
    {{-- Layanan --}}
    <section id="layanan" class="section-padding home-services">
        <div class="container">
            <div class="home-services-preview">
                <div class="home-services-list" data-aos="fade-right" data-aos-duration="900">
                    <div class="home-service-mini-card">
                        <div class="home-service-mini-icon">
                            <i class="bi bi-basket3"></i>
                        </div>

                        <div>
                            <h5>Cuci Komplit</h5>
                            <p>Cuci, kering, setrika, dan lipat rapi.</p>
                        </div>
                    </div>

                    <div class="home-service-mini-card">
                        <div class="home-service-mini-icon">
                            <i class="bi bi-wind"></i>
                        </div>

                        <div>
                            <h5>Cuci Kering</h5>
                            <p>Pakaian bersih dan kering tanpa setrika.</p>
                        </div>
                    </div>

                    <div class="home-service-mini-card">
                        <div class="home-service-mini-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>

                        <div>
                            <h5>Setrika Saja</h5>
                            <p>Pakaian dirapikan agar siap dipakai.</p>
                        </div>
                    </div>
                </div>

                <div class="home-services-content" data-aos="fade-left" data-aos-duration="900">
                    <span class="section-eyebrow">
                        <i class="bi bi-basket2"></i>
                        Layanan Triowash
                    </span>

                    <h2>
                        Pilih layanan laundry
                        <span>sesuai kebutuhanmu.</span>
                    </h2>

                    <p>
                        Kami menyediakan layanan utama yang simpel dan praktis. Untuk detail pilihan layanan,
                        berat cucian, dan proses pemesanan, pelanggan bisa langsung masuk ke halaman pesan.
                    </p>

                    <a href="/pesan" class="btn btn-primary btn-modern shadow-primary home-services-button">
                        <i class="bi bi-bag-plus"></i>
                        Pesan Laundry
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Keunggulan --}}
    <section id="keunggulan" class="section-padding home-advantages">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <span class="section-eyebrow">
                    <i class="bi bi-patch-check"></i>
                    Kenapa Memilih Kami
                </span>

                <h2>
                    Laundry modern,
                    <span>tanpa ribet.</span>
                </h2>

                <p>
                    Kami membuat proses laundry lebih nyaman, jelas, dan mudah dipantau dari awal sampai selesai.
                </p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="home-card">
                        <div class="home-card-icon">
                            <i class="bi bi-truck"></i>
                        </div>

                        <h5>Antar Jemput</h5>
                        <p>Kamu cukup pesan dari rumah atau kos, kurir kami yang ambil dan antar pakaianmu.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="home-card">
                        <div class="home-card-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <h5>Bayar Nanti</h5>
                        <p>Pakaian ditimbang transparan di toko, lalu tagihan muncul setelah proses dihitung.</p>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="home-card">
                        <div class="home-card-icon">
                            <i class="bi bi-stars"></i>
                        </div>

                        <h5>Pilihan Wangi</h5>
                        <p>Fleksibel pilih parfum favoritmu, dari wangi bunga, sport, sampai original.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection