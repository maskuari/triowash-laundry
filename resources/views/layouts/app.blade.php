<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Triowash Laundry</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @yield('styles')
</head>

<body>
    {{-- Header --}}
    <nav class="navbar navbar-expand-lg fixed-top navbar-modern" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand brand-logo" href="/" aria-label="Triowash Laundry">
                <img
                    src="{{ asset('assets/images/logo.png') }}"
                    alt="Triowash Laundry"
                    class="brand-logo-img"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
                >
                <span class="brand-logo-fallback">triowash</span>
            </a>

            <button
                class="navbar-toggler navbar-toggler-modern"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Buka menu navigasi"
            >
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav nav-modern ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/#layanan">Layanan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/#keunggulan">Keunggulan</a>
                    </li>

                    <li class="nav-item nav-cta ms-lg-3">
                        <a class="btn btn-outline-primary btn-modern" href="/pesan">
                            <i class="bi bi-bag-plus"></i>
                            Pesan Sekarang
                        </a>
                    </li>

                    <li class="nav-item nav-cta">
                        <a class="btn btn-primary btn-modern shadow-primary" href="/periksa-pesanan">
                            <i class="bi bi-search"></i>
                            Periksa Pesanan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Mobile Bottom Nav --}}
    <nav class="mobile-bottom-nav" aria-label="Navigasi mobile">
        <a href="/" class="mobile-bottom-link active">
            <i class="bi bi-house-door"></i>
            <span>Beranda</span>
        </a>

        <a href="/#layanan" class="mobile-bottom-link">
            <i class="bi bi-grid"></i>
            <span>Layanan</span>
        </a>

        <a href="/pesan" class="mobile-bottom-link mobile-bottom-main">
            <i class="bi bi-bag-plus"></i>
            <span>Pesan</span>
        </a>

        <a href="/periksa-pesanan" class="mobile-bottom-link">
            <i class="bi bi-search"></i>
            <span>Cek</span>
        </a>
    </nav>

    {{-- AI Chat Button --}}
    <button
        type="button"
        class="ai-chat-button"
        id="aiChatButton"
        aria-label="Buka AI Customer Service"
    >
        <span class="ai-chat-icon">
            <i class="bi bi-chat-dots-fill"></i>
        </span>

        <span class="ai-chat-text">
            <strong>AI CS</strong>
            <small>Butuh bantuan?</small>
        </span>
    </button>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer-modern">
        <div class="container">
            <div class="footer-panel">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <a class="footer-brand" href="/" aria-label="Triowash Laundry">
                            <img
                                src="{{ asset('assets/images/logo.png') }}"
                                alt="Triowash Laundry"
                                class="footer-logo-img"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
                            >
                            <span class="footer-logo-fallback">triowash</span>
                        </a>

                        <p class="footer-description mt-3">
                            Solusi laundry antar jemput yang praktis, modern, dan transparan untuk kebutuhan harian Anda.
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <h5 class="footer-title">Menu</h5>
                        <ul class="list-unstyled footer-links">
                            <li><a href="/">Beranda</a></li>
                            <li><a href="/pesan">Pesan Laundry</a></li>
                            <li><a href="/periksa-pesanan">Cek Status</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <h5 class="footer-title">Layanan</h5>
                        <ul class="list-unstyled footer-links">
                            <li>Cuci Komplit</li>
                            <li>Cuci Kering</li>
                            <li>Setrika Saja</li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <h5 class="footer-title">Kontak</h5>
                        <ul class="list-unstyled footer-links footer-contact">
                            <li><i class="bi bi-whatsapp"></i> +62 812-3456-7890</li>
                            <li><i class="bi bi-geo-alt"></i> Banjarmasin, Kalimantan Selatan</li>
                            <li><i class="bi bi-instagram"></i> @triowash_laundry</li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom">
                    <small>&copy; {{ date('Y') }} Triowash Laundry. All rights reserved.</small>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    @yield('scripts')
</body>

</html>