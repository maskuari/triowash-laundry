@extends('layouts.app')

@section('title', 'Layanan Antar Jemput Praktis')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="home-hero">
        <div class="home-hero-orb home-hero-orb-1"></div>
        <div class="home-hero-orb home-hero-orb-2"></div>

        <div class="container position-relative z-index-1">
            <div class="row align-items-center home-hero-row">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <div class="home-hero-content">
                        <div class="home-mobile-visual">
                            <img src="{{ asset('assets/images/baju.png') }}" alt="Triowash Laundry Service"
                                class="home-hero-image">
                        </div>

                        <h1 class="home-hero-title">
                            <span>Triowash Laundry</span>
                            <strong>Layanan Praktis.</strong>
                        </h1>

                        <p class="home-hero-description home-hero-description-small">
                            Antar jemput untuk wilayah Banjarmasin. Cuci bersih, wangi, dan rapi tanpa perlu keluar rumah.
                            Sistem bayar di akhir yang aman dan transparan.
                        </p>

                        <div class="home-info-wrap">
                            <div class="home-store-card">
                                <div class="home-store-top">
                                    <div class="home-store-status-dot {{ $storeStatus?->is_open ? 'open' : 'closed' }}">
                                    </div>
                                    <strong>Toko {{ $storeStatus?->label ?? 'Buka' }}</strong>

                                    @if ($storeStatus?->status_note)
                                        <span>{{ $storeStatus->status_note }}</span>
                                    @else
                                        <span>Kami siap melayani antar jemput hari ini.</span>
                                    @endif
                                </div>

                                <div class="home-store-hours">
                                    <div>
                                        <i class="bi bi-truck"></i>
                                        <span>Antar jemput</span>
                                        <strong>08:00 - 17:00 WITA</strong>
                                    </div>

                                    <div>
                                        <i class="bi bi-shop"></i>
                                        <span>Laundry</span>
                                        <strong>07:00 - 21:30 WITA</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="home-location-card">
                                <i class="bi bi-geo-alt-fill"></i>
                                <div>
                                    <span>Lokasi</span>
                                    <strong>Triowash - Pangeran, Banjarmasin.</strong>
                                </div>
                            </div>
                        </div>

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
                                <strong>08-17</strong>
                                <span>Antar Jemput</span>
                            </div>

                            <div class="home-stat-card">
                                <i class="bi bi-grid-1x2 home-stat-icon home-stat-icon-blue"></i>
                                <strong>{{ $services->count() }}+</strong>
                                <span>Pilihan Paket</span>
                            </div>

                            <div class="home-stat-card">
                                <i class="bi bi-bag-check home-stat-icon home-stat-icon-purple"></i>
                                <strong>{{ $orderStats['total_orders'] }}</strong>
                                <span>Total Pesanan</span>
                            </div>
                        </div>
                    </div>
                </div>

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
                                <span>Triowash - Pangeran, Banjarmasin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="section-padding home-services">
        <div class="container">
            <div class="home-services-preview">
                <div class="home-services-list" data-aos="fade-right" data-aos-duration="900">
                    @forelse ($services as $service)
                        <div class="home-service-mini-card">
                            <div class="home-service-mini-icon">
                                <i class="bi bi-basket3"></i>
                            </div>

                            <div>
                                <h5>{{ $service->service_name }}</h5>
                                <p>Mulai dari Rp{{ number_format($service->price_per_kg, 0, ',', '.') }}/kg.</p>
                            </div>
                        </div>
                    @empty
                        <div class="home-service-mini-card">
                            <div class="home-service-mini-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>

                            <div>
                                <h5>Belum ada paket</h5>
                                <p>Data paket akan tampil setelah admin menambahkan paket.</p>
                            </div>
                        </div>
                    @endforelse
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
                        Kami menyediakan paket laundry, pilihan layanan regular atau express,
                        pilihan wangi, dan opsi antar jemput yang bisa dipilih langsung saat pemesanan.
                    </p>

                    <a href="/pesan" class="btn btn-primary btn-modern shadow-primary home-services-button">
                        <i class="bi bi-bag-plus"></i>
                        Pesan Laundry
                    </a>
                </div>
            </div>
        </div>
    </section>

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
                        <p>Antar jemput tersedia dari jam 08:00 sampai 17:00 WITA.</p>
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

    @if ($testimonials->isNotEmpty())
        <section class="section-padding home-testimonials">
            <div class="container">
                <div class="section-heading text-center" data-aos="fade-up">
                    <span class="section-eyebrow">
                        <i class="bi bi-chat-heart"></i>
                        Testimoni
                    </span>

                    <h2>
                        Kata pelanggan
                        <span>tentang Triowash.</span>
                    </h2>

                    <p>
                        Beberapa pengalaman pelanggan yang sudah menggunakan layanan Triowash Laundry.
                    </p>
                </div>

                <div class="row g-4 mt-4">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="home-testimonial-card">
                                <div class="home-testimonial-stars">
                                    @for ($i = 1; $i <= $testimonial->rating; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>

                                <p>"{{ $testimonial->message }}"</p>

                                <div>
                                    <strong>{{ $testimonial->customer_name }}</strong>
                                    <span>{{ $testimonial->customer_role ?? 'Pelanggan Triowash' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection