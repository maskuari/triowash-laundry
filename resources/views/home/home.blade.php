@extends('layouts.app')

@section('title', 'Layanan Antar Jemput Praktis')

@section('content')
    {{-- Hero --}}
    <section class="hero-wrapper">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>

        <div class="container position-relative z-index-1">
            <div class="row align-items-center hero-row">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="bi bi-stars"></i>
                            Promo Member Baru: Diskon 10%
                        </div>

                        {{-- Mobile Image --}}
                        <div class="hero-mobile-visual">
                            <img
                                src="{{ asset('assets/images/baju.png') }}"
                                alt="Triowash Laundry Service"
                                class="img-fluid hero-image"
                            >
                        </div>

                        <h1 class="hero-title">
                            <span class="hero-title-main">Triowash Laundry</span>
                            <span class="hero-title-highlight">Layanan Praktis.</span>
                        </h1>

                        <p class="hero-description">
                            Antar jemput gratis untuk wilayah Banjarmasin. Cuci bersih, wangi, dan rapi tanpa perlu keluar rumah.
                            Sistem bayar di akhir yang aman dan transparan.
                        </p>

                        <div class="hero-actions">
                            <a href="/pesan" class="btn btn-primary btn-hero shadow-primary">
                                <i class="bi bi-bag-heart"></i>
                                Pesan Sekarang
                            </a>

                            <a href="/periksa-pesanan" class="btn btn-light btn-hero btn-hero-secondary">
                                <i class="bi bi-search"></i>
                                Periksa Pesanan
                            </a>
                        </div>

                        <div class="hero-stats">
                            <div class="hero-stat-card">
                                <i class="bi bi-truck hero-stat-icon"></i>
                                <strong>Gratis</strong>
                                <span>Antar Jemput</span>
                            </div>

                            <div class="hero-stat-card">
                                <i class="bi bi-grid-1x2 hero-stat-icon hero-stat-icon-blue"></i>
                                <strong>3+</strong>
                                <span>Pilihan Layanan</span>
                            </div>

                            <div class="hero-stat-card">
                                <i class="bi bi-lightning-charge hero-stat-icon hero-stat-icon-purple"></i>
                                <strong>Fast</strong>
                                <span>Proses Cepat</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Desktop Image --}}
                <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="hero-visual">
                        <div class="hero-visual-glow"></div>

                        <img
                            src="{{ asset('assets/images/baju.png') }}"
                            alt="Triowash Laundry Service"
                            class="img-fluid hero-image"
                        >

                        <div class="floating-card floating-card-quality">
                            <div class="floating-icon floating-icon-blue">
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
    <section id="layanan" class="section-padding services-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <span class="section-eyebrow">
                    <i class="bi bi-basket2"></i>
                    Layanan Triowash
                </span>

                <h2>
                    Pilih layanan laundry
                    <span>sesuai kebutuhanmu.</span>
                </h2>

                <p>
                    Mulai dari cuci komplit, cuci kering, sampai setrika saja. Semua dibuat praktis, rapi, dan transparan.
                </p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-basket3"></i>
                        </div>

                        <h5>Cuci Komplit</h5>
                        <p>Cuci, kering, setrika, dan lipat rapi untuk pakaian harian Anda.</p>

                        <a href="/pesan" class="service-link">
                            Pesan layanan
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="bi bi-wind"></i>
                        </div>

                        <h5>Cuci Kering</h5>
                        <p>Cocok untuk Anda yang ingin pakaian bersih dan kering tanpa setrika.</p>

                        <a href="/pesan" class="service-link">
                            Pesan layanan
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card service-card-featured">
                        <div class="service-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>

                        <h5>Setrika Saja</h5>
                        <p>Untuk pakaian bersih yang butuh dirapikan agar siap dipakai lagi.</p>

                        <a href="/pesan" class="service-link">
                            Pesan layanan
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Keunggulan --}}
    <section id="keunggulan" class="section-padding advantages-section">
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
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>

                        <h5>Antar Jemput</h5>
                        <p>Kamu cukup pesan dari rumah atau kos, kurir kami yang ambil dan antar pakaianmu.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <h5>Bayar Nanti</h5>
                        <p>Pakaian ditimbang transparan di toko, lalu tagihan muncul setelah proses dihitung.</p>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box">
                        <div class="feature-icon">
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