@extends('layouts.app')

@section('title', 'Layanan Antar Jemput Praktis')

@section('content')
    {{-- Hero --}}
    <section class="hero-wrapper position-relative d-flex align-items-center">
        <div class="blob-shape blob-1"></div>
        <div class="blob-shape blob-2"></div>

        <div class="container position-relative z-index-1">
            <div class="row align-items-center pt-4 pb-4 g-5">
                <div class="col-lg-6 text-center text-lg-start" data-aos="fade-right" data-aos-duration="1000">
                    <div class="badge bg-primary-subtle text-primary rounded-pill px-4 py-2 mb-3 fw-semibold border border-primary-subtle shadow-sm">
                        <i class="bi bi-tag-fill text-warning me-1"></i>
                        Promo Member Baru: Diskon 10%
                    </div>

                    <h1 class="display-4 fw-extrabold text-dark mb-3 hero-title">
                        Triowash Laundry<br>
                        <span class="text-gradient">Layanan Praktis.</span>
                    </h1>

                    <p class="lead text-secondary mb-5 fw-normal pe-lg-5">
                        Antar Jemput Gratis untuk wilayah Banjarmasin. Cuci bersih, wangi, dan rapi tanpa perlu keluar rumah.
                        Sistem bayar di akhir yang aman dan terpercaya.
                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <a href="/pesan" class="btn btn-primary btn-lg btn-modern px-5 py-3 shadow-primary d-flex align-items-center justify-content-center">
                            <i class="bi bi-basket2-fill me-2 fs-5"></i>
                            PESAN SEKARANG
                        </a>

                        <a href="/periksa-pesanan" class="btn btn-outline-success btn-lg btn-modern px-5 py-3 bg-white d-flex align-items-center justify-content-center">
                            <i class="bi bi-search me-2 fs-5"></i>
                            PERIKSA PESANAN
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="position-relative p-3 text-center">
                        <div class="card glass-card position-absolute border-0 floating-card floating-card-delivery">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-circle icon-circle-sm bg-success-subtle text-success d-flex align-items-center justify-content-center">
                                    <i class="bi bi-truck fs-3"></i>
                                </div>

                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold text-dark">Gratis Ongkir!</h6>
                                    <small class="text-muted">Antar Jemput</small>
                                </div>
                            </div>
                        </div>

                        <img
                            src="{{ asset('assets/images/baju.png') }}"
                            alt="Triowash Laundry Service"
                            class="img-fluid rounded-5 position-relative z-index-1 hero-image"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Keunggulan --}}
    <section id="keunggulan" class="section-padding bg-white position-relative">
        <div class="position-absolute top-0 start-50 translate-middle-x w-100 divider-glow"></div>

        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-4 py-2 mb-3 fw-bold tracking-wider text-uppercase border border-primary-subtle shadow-sm">
                    <i class="bi bi-patch-check-fill me-1"></i>
                    Kenapa Memilih Kami
                </span>

                <h2 class="fw-extrabold display-5 mt-2 mb-3 text-dark">
                    Layanan Bintang Lima, <br>
                    <span class="text-gradient">Harga Mahasiswa.</span>
                </h2>

                <p class="text-secondary mx-auto lead section-description">
                    Kami mengerti kebutuhan Anda. Kualitas pencucian premium dengan pelayanan maksimal, namun tetap pas di kantong.
                </p>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-slash"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Tanpa Akun</h5>
                            <p class="text-muted small mb-0 lh-sm">
                                Nggak perlu repot bikin password. Cukup verifikasi pakai Nama dan No HP kamu.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-truck"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Antar Jemput</h5>
                            <p class="text-muted small mb-0 lh-sm">
                                Kamu rebahan aja di kos, kurir kami yang akan ambil dan antar pakaianmu.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Bayar Nanti</h5>
                            <p class="text-muted small mb-0 lh-sm">
                                Pakaian ditimbang transparan di toko, baru tagihan muncul untuk dibayar.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-box p-3 p-md-4 rounded-4 bg-light d-flex flex-row flex-md-column align-items-center text-start text-md-center h-100 transition-all mobile-app-card">
                        <div class="feature-icon bg-white text-primary rounded-circle shadow-sm flex-shrink-0 me-3 me-md-0 mb-md-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-stars"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1 mb-md-2">Pilihan Wangi</h5>
                            <p class="text-muted small mb-0 lh-sm">
                                Fleksibel pilih parfum kesukaanmu. Wangi Bunga, Sport, atau Original.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection