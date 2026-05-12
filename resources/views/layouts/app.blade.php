<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Triowash Laundry</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('styles')
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top bg-white border-bottom shadow-sm" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="brand-icon-wrapper me-2">
                    <i class="bi bi-droplet-half text-white fs-5"></i>
                </div>
                <span class="fw-bold fs-4 text-dark brand-text">Triowash</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center fw-medium gap-lg-3 py-3 py-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-dark px-0 px-lg-2" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark px-0 px-lg-2" href="#keunggulan">Keunggulan</a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0 ms-lg-3">
                        <a class="btn btn-outline-primary w-100 btn-modern px-4" href="/pesan">
                            <i class="bi bi-cart-plus me-1"></i> Pesan Sekarang
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-primary w-100 btn-modern px-4 shadow-primary" href="/periksa-pesanan">
                            <i class="bi bi-search me-1"></i> Periksa Pesanan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-modern bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="brand-icon-wrapper me-2 bg-white">
                            <i class="bi bi-droplet-half text-primary fs-4"></i>
                        </div>
                        <span class="fw-bold fs-4">Triowash</span>
                    </div>
                    <p class="text-white-50">Solusi laundry praktis, cepat, dan transparan untuk kebutuhan harian Anda.
                        Tinggal pesan, kami jemput!</p>
                </div>
                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="fw-bold mb-3">Menu</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/pesan">Pesan Laundry</a></li>
                        <li><a href="/periksa-pesanan">Cek Status</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="fw-bold mb-3">Layanan Kami</h5>
                    <ul class="list-unstyled footer-links text-white-50">
                        <li>Cuci Komplit (Setrika + Lipat)</li>
                        <li>Cuci Kering (Lipat Saja)</li>
                        <li>Setrika Saja</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <h5 class="fw-bold mb-3">Kontak</h5>
                    <ul class="list-unstyled footer-links text-white-50">
                        <li><i class="bi bi-whatsapp me-2"></i> +62 812-3456-7890</li>
                        <li><i class="bi bi-geo-alt me-2"></i> Banjarmasin, Kalimantan Selatan</li>
                        <li><i class="bi bi-instagram me-2"></i> @triowash_laundry</li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary pt-3 text-center text-white-50">
                <small>&copy; 2026 Triowash Laundry. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>

</html>