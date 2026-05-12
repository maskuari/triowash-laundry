@extends('layouts.app')

@section('title', 'Layanan Antar Jemput Praktis')

@section('content')
    <section class="hero-wrapper position-relative d-flex align-items-center">
        <div class="blob-shape blob-1"></div>
        <div class="blob-shape blob-2"></div>

        <div class="container position-relative z-index-1">
            <div class="row align-items-center pt-4 pb-4">
                <div class="col-lg-6 text-center text-lg-start" data-aos="fade-right" data-aos-duration="1000">
                    <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3 fw-semibold">
                        <i class="bi bi-star-fill text-warning me-1"></i> Tanpa Perlu Bikin Akun!
                    </div>
                    <h1 class="display-3 fw-extrabold text-dark mb-4 hero-title">
                        Laundry Cepat,<br> <span class="text-gradient">Nggak Pake Ribet.</span>
                    </h1>
                    <p class="lead text-secondary mb-5 fw-normal pe-lg-5">
                        Layanan laundry antar-jemput pertama dengan sistem bayar di akhir dan *tracking* super mudah. Cukup
                        masukkan nama dan nomor WhatsApp kamu.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <a href="/pesan" class="btn btn-primary btn-lg btn-modern px-5 shadow-primary">
                            Mulai Pesan <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#cara-kerja" class="btn btn-light btn-lg btn-modern px-5 shadow-sm text-dark">
                            <i class="bi bi-play-circle text-primary me-2"></i> Cara Kerja
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="row g-4 position-relative cta-cards-container">
                        <div class="col-md-6">
                            <div class="card glass-card h-100 border-0 p-4 text-center floating-card">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <div class="icon-circle bg-primary-subtle text-primary mb-4">
                                        <i class="bi bi-basket2-fill fs-2"></i>
                                    </div>
                                    <h4 class="fw-bold mb-2">Pesan Baru</h4>
                                    <p class="text-muted small mb-4">Pilih paket, tentukan wangi, dan atur lokasi
                                        penjemputan.</p>
                                    <a href="/pesan"
                                        class="btn btn-outline-primary btn-modern w-100 mt-auto stretched-link">Pesan</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-md-5">
                            <div class="card glass-card h-100 border-0 p-4 text-center floating-card delay-1">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <div class="icon-circle bg-success-subtle text-success mb-4">
                                        <i class="bi bi-clipboard2-check-fill fs-2"></i>
                                    </div>
                                    <h4 class="fw-bold mb-2">Cek Status</h4>
                                    <p class="text-muted small mb-4">Lacak pakaianmu dari dijemput, diproses, sampai
                                        diantar.</p>
                                    <a href="/periksa-pesanan"
                                        class="btn btn-success btn-modern w-100 mt-auto stretched-link shadow-success">Periksa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="section-padding bg-white position-relative">
        <div class="position-absolute top-0 start-50 translate-middle-x w-100 divider-glow"></div>

        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span
                    class="badge bg-primary-subtle text-primary rounded-pill px-4 py-2 mb-3 fw-bold tracking-wider text-uppercase border border-primary-subtle shadow-sm">
                    <i class="bi bi-patch-check-fill me-1"></i> Kenapa Memilih Kami
                </span>
                <h2 class="fw-extrabold display-5 mt-2 mb-3 text-dark">
                    Layanan Bintang Lima, <br>
                    <span class="text-gradient">Harga Mahasiswa.</span>
                </h2>
                <p class="text-secondary mx-auto lead" style="max-width: 600px; font-size: 1.1rem;">
                    Kami mengerti kebutuhan Anda. Kualitas pencucian premium dengan pelayanan maksimal, namun tetap pas di
                    kantong.
                </p>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div
                            class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-slash"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Tanpa Akun</h5>
                            <p class="text-muted small mb-0 lh-sm">Nggak perlu repot bikin password. Cukup verifikasi pakai
                                Nama dan No HP kamu.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div
                            class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Antar Jemput</h5>
                            <p class="text-muted small mb-0 lh-sm">Kamu rebahan aja di kos, kurir kami yang akan ambil dan
                                antar pakaianmu.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div
                            class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Bayar Nanti</h5>
                            <p class="text-muted small mb-0 lh-sm">Pakaian ditimbang transparan di toko, baru tagihan muncul
                                untuk dibayar.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div
                            class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-stars"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Pilihan Wangi</h5>
                            <p class="text-muted small mb-0 lh-sm">Fleksibel pilih parfum kesukaanmu. Wangi Bunga, Sport,
                                atau Original.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection