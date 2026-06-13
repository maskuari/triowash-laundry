@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="admin-page">
        <aside class="admin-sidebar">
            <a href="/admin" class="admin-brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Triowash"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                <span>triowash</span>
            </a>

            <nav class="admin-menu">
                <a href="#dashboard" class="admin-menu-link active">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#input-pesanan" class="admin-menu-link">
                    <i class="bi bi-person-plus"></i>
                    <span>Input Pesanan</span>
                </a>

                <a href="#masuk" class="admin-menu-link">
                    <i class="bi bi-inbox-fill"></i>
                    <span>Pesanan Masuk</span>
                    <small>{{ $stats['incoming_orders'] ?? 0 }}</small>
                </a>

                <a href="#diproses" class="admin-menu-link">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Diproses</span>
                    <small>{{ ($stats['approved_orders'] ?? 0) + ($stats['processing_orders'] ?? 0) }}</small>
                </a>

                <a href="#selesai" class="admin-menu-link">
                    <i class="bi bi-box-seam"></i>
                    <span>Selesai</span>
                    <small>{{ $stats['finished_orders'] ?? 0 }}</small>
                </a>

                <a href="#setting-toko" class="admin-menu-link">
                    <i class="bi bi-shop"></i>
                    <span>Setting Toko</span>
                </a>

                <a href="#paket-layanan" class="admin-menu-link">
                    <i class="bi bi-basket2-fill"></i>
                    <span>Paket & Layanan</span>
                </a>

                <a href="#wangi" class="admin-menu-link">
                    <i class="bi bi-stars"></i>
                    <span>Wangi</span>
                </a>

                <a href="#pickup" class="admin-menu-link">
                    <i class="bi bi-truck"></i>
                    <span>Antar Jemput</span>
                </a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" class="admin-sidebar-logout">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Keluar Admin</span>
                </button>
            </form>

            <div class="admin-sidebar-card">
                <i class="bi bi-robot"></i>
                <h6>AI CS Aktif</h6>
                <p>Customer service otomatis siap membantu pelanggan.</p>
                <a href="/cs-ai">Lihat AI</a>
            </div>
        </aside>

        <main class="admin-main">
            @if (session('success'))
                <div class="alert alert-success rounded-4 fw-bold mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger rounded-4 fw-bold mb-3">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-4 fw-bold mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <header class="admin-topbar">
                <div>
                    <span class="admin-eyebrow">Dashboard Admin</span>
                    <h1>Kelola Operasional Triowash</h1>
                    <p>Kelola pesanan, paket, layanan, wangi, antar jemput, dan status toko.</p>
                </div>
            </header>

            <section id="dashboard" class="admin-summary-grid">
                <div class="admin-summary-card">
                    <div class="admin-summary-icon blue">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <div>
                        <span>Pesanan Masuk</span>
                        <strong>{{ $stats['incoming_orders'] ?? 0 }}</strong>
                        <small>Menunggu ACC</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon purple">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <span>Diproses</span>
                        <strong>{{ ($stats['approved_orders'] ?? 0) + ($stats['processing_orders'] ?? 0) }}</strong>
                        <small>ACC / berjalan</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon green">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <span>Selesai</span>
                        <strong>{{ $stats['finished_orders'] ?? 0 }}</strong>
                        <small>Siap / diterima</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon cyan">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <span>Pendapatan Hari Ini</span>
                        <strong>Rp{{ number_format($stats['today_revenue'] ?? 0, 0, ',', '.') }}</strong>
                        <small>{{ $stats['paid_orders'] ?? 0 }} pesanan lunas</small>
                    </div>
                </div>
            </section>

            <section class="admin-content-list">
                {{-- Input Pesanan Manual --}}
<div id="input-pesanan" class="admin-panel admin-panel-full">
    <div class="admin-panel-header">
        <div>
            <span>Manual Order</span>
            <h2>Input Pesanan Pelanggan</h2>
        </div>
    </div>

        <form method="POST" action="{{ route('admin.orders.manual-store') }}" class="admin-manual-order-form">
            @csrf

        <div>
            <label>Nama Pelanggan</label>
            <input
                type="text"
                name="name"
                placeholder="Contoh: Budi Santoso"
                value="{{ old('name') }}"
            >
        </div>

        <div>
            <label>Nomor HP</label>
            <input
                type="text"
                name="phone"
                placeholder="Contoh: 081234567890"
                value="{{ old('phone') }}"
            >
        </div>

        <div class="admin-form-full">
            <label>Alamat Lengkap</label>
            <textarea
                name="address"
                rows="3"
                placeholder="Contoh: Jl. Pangeran No. 10, RT 05, Banjarmasin"
            >{{ old('address') }}</textarea>
        </div>

        <div>
            <label>Paket</label>
            <div class="admin-select-field">
                <i class="bi bi-basket2"></i>
                <select name="service_id">
                    <option value="">Pilih Paket</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}" @selected(old('service_id') == $package->id)>
                            {{ $package->service_name }} - Rp{{ number_format($package->price_per_kg, 0, ',', '.') }}/kg
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label>Layanan</label>
            <div class="admin-select-field">
                <i class="bi bi-lightning-charge"></i>
                <select name="service_type_id">
                    <option value="">Pilih Layanan</option>
                    @foreach ($serviceTypes as $serviceType)
                        <option value="{{ $serviceType->id }}" @selected(old('service_type_id') == $serviceType->id)>
                            {{ $serviceType->service_name }} - Rp{{ number_format($serviceType->price_per_kg, 0, ',', '.') }}/kg
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label>Pilihan Wangi</label>
            <div class="admin-select-field">
                <i class="bi bi-stars"></i>
                <select name="fragrance_id">
                    <option value="">Tanpa Wangi</option>
                    @foreach ($fragrances as $fragrance)
                        <option value="{{ $fragrance->id }}" @selected(old('fragrance_id') == $fragrance->id)>
                            {{ $fragrance->service_name }}
                            @if ($fragrance->price_per_kg > 0)
                                - Rp{{ number_format($fragrance->price_per_kg, 0, ',', '.') }}/kg
                            @else
                                - Gratis
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label>Opsi Antar-Jemput</label>
            <div class="admin-select-field">
                <i class="bi bi-truck"></i>
                <select name="pickup_option_id">
                    <option value="">Pilih Opsi</option>
                    @foreach ($pickupOptions->where('is_active', true) as $pickupOption)
                        @continue($pickupOption->code === 'antar_ambil_sendiri' || str_contains(strtolower($pickupOption->name), 'ambil sendiri'))
                        <option value="{{ $pickupOption->id }}" @selected(old('pickup_option_id') == $pickupOption->id)>
                            {{ $pickupOption->name }}
                            @if (($pickupOption->price ?? 0) > 0)
                                - Rp{{ number_format($pickupOption->price, 0, ',', '.') }}
                            @else
                                - Gratis
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="admin-form-full">
            <label>Catatan Tambahan <span>opsional</span></label>
            <textarea
                name="notes"
                rows="3"
                placeholder="Contoh: Tolong pisahkan baju putih dan berwarna."
            >{{ old('notes') }}</textarea>
        </div>

        <div class="admin-form-full">
            <button type="submit" class="admin-btn-primary">
                <i class="bi bi-plus-circle"></i>
                Simpan Pesanan Pelanggan
            </button>
        </div>
    </form>
</div>
                {{-- Pesanan Masuk --}}
                <div id="masuk" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header admin-panel-header-search">
                        <div>
                            <span>Incoming</span>
                            <h2>Pesanan Masuk</h2>
                        </div>

                        <div class="admin-header-actions">
                            <form method="POST" action="{{ route('admin.orders.approve-all') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="admin-action success"
                                    onclick="return confirm('Terima semua pesanan masuk?')">
                                    Terima Semua
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.orders.reject-all') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-action danger"
                                    onclick="return confirm('Tolak dan hapus semua pesanan masuk?')">
                                    Tolak Semua
                                </button>
                            </form>

                            <form method="GET" action="{{ route('admin.dashboard') }}" class="admin-section-search-form">
                                <input type="hidden" name="search_diproses" value="{{ $searchDiproses ?? '' }}">
                                <input type="hidden" name="search_selesai" value="{{ $searchSelesai ?? '' }}">

                                <div class="admin-section-search">
                                    <i class="bi bi-search"></i>
                                    <input type="text" name="search_masuk" placeholder="Cari kode, nama, nomor, layanan..."
                                        value="{{ $searchMasuk ?? '' }}">
                                </div>

                                <button type="submit" class="admin-btn-primary">Cari</button>

                                @if (!empty($searchMasuk))
                                                            <a href="{{ route('admin.dashboard', [
                                        'search_diproses' => $searchDiproses ?? '',
                                        'search_selesai' => $searchSelesai ?? '',
                                    ]) }}#masuk" class="admin-btn-secondary text-decoration-none">
                                                                Reset
                                                            </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="admin-table-scroll">
                        <div class="admin-table-wrapper">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Pelanggan</th>
                                        <th>Layanan</th>
                                        <th>Opsi</th>
                                        <th>Status</th>
                                        <th>Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($incomingOrders as $order)
                                        @php
                                            $mainService = $order->orderItems->firstWhere('service.category', 'paket')?->service;
                                            $serviceType = $order->orderItems->firstWhere('service.category', 'layanan')?->service;
                                            $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
                                        @endphp

                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_code }}</strong>
                                                <small
                                                    class="d-block text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                            </td>

                                            <td>
                                                <div class="admin-customer">
                                                    <span>{{ $order->customer->name }}</span>
                                                    <small>{{ $order->customer->phone }}</small>
                                                </div>
                                            </td>

                                            <td>
                                                {{ $mainService?->service_name ?? '-' }}
                                                @if ($serviceType)
                                                    <small class="d-block text-muted">{{ $serviceType->service_name }}</small>
                                                @endif
                                                @if ($fragrance)
                                                    <small class="d-block text-muted">{{ $fragrance->service_name }}</small>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}
                                                @if (($order->pickupOption?->price ?? 0) > 0)
                                                    <small class="d-block text-muted">
                                                        Rp{{ number_format($order->pickupOption->price, 0, ',', '.') }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="admin-badge warning">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>

                                            <td>
                                                <span
                                                    class="admin-badge {{ $order->payment_status === 'paid' ? 'done' : 'warning' }}">
                                                    {{ $order->payment_status_label }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="admin-table-actions">
                                                    <form method="POST"
                                                        action="{{ route('admin.orders.approve', $order->order_code) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="admin-action success" type="submit">ACC</button>
                                                    </form>

                                                    <form method="POST"
                                                        action="{{ route('admin.orders.reject', $order->order_code) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="admin-action danger" type="submit"
                                                            onclick="return confirm('Tolak pesanan ini? Pesanan akan otomatis terhapus.')">
                                                            Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted fw-bold py-4">
                                                Tidak ada pesanan masuk.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <p class="admin-table-note">Jika data lebih dari 10 baris, tabel bisa discroll.</p>
                </div>

                {{-- Pesanan Diproses --}}
                <div id="diproses" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header admin-panel-header-search">
                        <div>
                            <span>Process</span>
                            <h2>Pesanan Diproses</h2>
                        </div>

                        <form method="GET" action="{{ route('admin.dashboard') }}" class="admin-section-search-form">
                            <input type="hidden" name="search_masuk" value="{{ $searchMasuk ?? '' }}">
                            <input type="hidden" name="search_selesai" value="{{ $searchSelesai ?? '' }}">

                            <div class="admin-section-search">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search_diproses" placeholder="Cari kode, nama, nomor, layanan..."
                                    value="{{ $searchDiproses ?? '' }}">
                            </div>

                            <button type="submit" class="admin-btn-primary">Cari</button>

                            @if (!empty($searchDiproses))
                                                    <a href="{{ route('admin.dashboard', [
                                    'search_masuk' => $searchMasuk ?? '',
                                    'search_selesai' => $searchSelesai ?? '',
                                ]) }}#diproses" class="admin-btn-secondary text-decoration-none">
                                                        Reset
                                                    </a>
                            @endif
                        </form>
                    </div>

                    <div class="admin-table-scroll">
                        <div class="admin-table-wrapper">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Pelanggan</th>
                                        <th>Layanan</th>
                                        <th>Opsi</th>
                                        <th>Status</th>
                                        <th>Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($processedOrders as $order)
                                        @php
                                            $mainService = $order->orderItems->firstWhere('service.category', 'paket')?->service;
                                            $serviceType = $order->orderItems->firstWhere('service.category', 'layanan')?->service;
                                            $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
                                        @endphp

                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_code }}</strong>
                                                <small
                                                    class="d-block text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                            </td>

                                            <td>
                                                <div class="admin-customer">
                                                    <span>{{ $order->customer->name }}</span>
                                                    <small>{{ $order->customer->phone }}</small>
                                                </div>
                                            </td>

                                            <td>
                                                {{ $mainService?->service_name ?? '-' }}
                                                @if ($serviceType)
                                                    <small class="d-block text-muted">{{ $serviceType->service_name }}</small>
                                                @endif
                                                @if ($fragrance)
                                                    <small class="d-block text-muted">{{ $fragrance->service_name }}</small>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}
                                                @if (($order->pickupOption?->price ?? 0) > 0)
                                                    <small class="d-block text-muted">
                                                        Rp{{ number_format($order->pickupOption->price, 0, ',', '.') }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="admin-badge process">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>

                                            <td>
                                                <span
                                                    class="admin-badge {{ $order->payment_status === 'paid' ? 'done' : 'warning' }}">
                                                    {{ $order->payment_status_label }}
                                                </span>
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->order_code) }}"
                                                    class="admin-action primary text-decoration-none">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted fw-bold py-4">
                                                Tidak ada pesanan diproses.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <p class="admin-table-note">Jika data lebih dari 10 baris, tabel bisa discroll.</p>
                </div>

                {{-- Pesanan Selesai --}}
                <div id="selesai" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header admin-panel-header-search">
                        <div>
                            <span>Done</span>
                            <h2>Pesanan Selesai</h2>
                        </div>

                        <form method="GET" action="{{ route('admin.dashboard') }}" class="admin-section-search-form">
                            <input type="hidden" name="search_masuk" value="{{ $searchMasuk ?? '' }}">
                            <input type="hidden" name="search_diproses" value="{{ $searchDiproses ?? '' }}">

                            <div class="admin-section-search">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search_selesai" placeholder="Cari kode, nama, nomor, layanan..."
                                    value="{{ $searchSelesai ?? '' }}">
                            </div>

                            <button type="submit" class="admin-btn-primary">Cari</button>

                            @if (!empty($searchSelesai))
                                                    <a href="{{ route('admin.dashboard', [
                                    'search_masuk' => $searchMasuk ?? '',
                                    'search_diproses' => $searchDiproses ?? '',
                                ]) }}#selesai" class="admin-btn-secondary text-decoration-none">
                                                        Reset
                                                    </a>
                            @endif
                        </form>
                    </div>

                    <div class="admin-table-scroll">
                        <div class="admin-table-wrapper">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Pelanggan</th>
                                        <th>Layanan</th>
                                        <th>Opsi</th>
                                        <th>Status</th>
                                        <th>Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($finishedOrders as $order)
                                        @php
                                            $mainService = $order->orderItems->firstWhere('service.category', 'paket')?->service;
                                            $serviceType = $order->orderItems->firstWhere('service.category', 'layanan')?->service;
                                            $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
                                        @endphp

                                        <tr>
                                            <td>
                                                <strong>{{ $order->order_code }}</strong>
                                                <small
                                                    class="d-block text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                            </td>

                                            <td>
                                                <div class="admin-customer">
                                                    <span>{{ $order->customer->name }}</span>
                                                    <small>{{ $order->customer->phone }}</small>
                                                </div>
                                            </td>

                                            <td>
                                                {{ $mainService?->service_name ?? '-' }}
                                                @if ($serviceType)
                                                    <small class="d-block text-muted">{{ $serviceType->service_name }}</small>
                                                @endif
                                                @if ($fragrance)
                                                    <small class="d-block text-muted">{{ $fragrance->service_name }}</small>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}
                                                @if (($order->pickupOption?->price ?? 0) > 0)
                                                    <small class="d-block text-muted">
                                                        Rp{{ number_format($order->pickupOption->price, 0, ',', '.') }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="admin-badge done">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>

                                            <td>
                                                <span
                                                    class="admin-badge {{ $order->payment_status === 'paid' ? 'done' : 'warning' }}">
                                                    {{ $order->payment_status_label }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="admin-table-actions">
                                                    <a href="{{ route('admin.orders.show', $order->order_code) }}"
                                                        class="admin-action primary text-decoration-none">
                                                        Detail
                                                    </a>

                                                    <form method="POST"
                                                        action="{{ route('admin.orders.delete', $order->order_code) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="admin-action danger" type="submit"
                                                            onclick="return confirm('Hapus data pesanan selesai ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted fw-bold py-4">
                                                Tidak ada pesanan selesai.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <p class="admin-table-note">Jika data lebih dari 10 baris, tabel bisa discroll.</p>
                </div>

                {{-- Setting Toko --}}
                <div id="setting-toko" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Store</span>
                            <h2>Status Toko</h2>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.store-status.update') }}" class="admin-setting-form">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label>Status Laundry</label>
                            <select name="is_open">
                                <option value="1" @selected($storeStatus?->is_open)>Buka</option>
                                <option value="0" @selected(!$storeStatus?->is_open)>Tutup</option>
                            </select>
                        </div>

                        <div>
                            <label>Catatan Status</label>
                            <select name="status_note">
                                <option value="Kami siap melayani Anda."
                                    @selected($storeStatus?->status_note === 'Kami siap melayani Anda.')>
                                    Kami siap melayani Anda.
                                </option>

                                <option value="Kami akan buka kembali besok hari."
                                    @selected($storeStatus?->status_note === 'Kami akan buka kembali besok hari.')>
                                    Kami akan buka kembali besok hari.
                                </option>

                                <option value="Kami akan buka kembali dalam waktu dekat."
                                    @selected($storeStatus?->status_note === 'Kami akan buka kembali dalam waktu dekat.')>
                                    Kami akan buka kembali dalam waktu dekat.
                                </option>

                                <option value="Kami akan buka kembali lusa." @selected($storeStatus?->status_note === 'Kami akan buka kembali lusa.')>
                                    Kami akan buka kembali lusa.
                                </option>

                                <option value="Layanan sedang ditutup sementara karena ada penyesuaian operasional."
                                    @selected($storeStatus?->status_note === 'Layanan sedang ditutup sementara karena ada penyesuaian operasional.')>
                                    Layanan sedang ditutup sementara karena ada penyesuaian operasional.
                                </option>
                            </select>
                        </div>

                        <div class="admin-empty-box admin-setting-full">
                            <i class="bi bi-info-circle"></i>
                            <p>
                                Jam antar jemput: 08:00 - 17:00 WITA. Laundry buka: 07:00 - 21:30 WITA.
                            </p>
                        </div>

                        <button type="submit" class="admin-btn-primary">
                            Simpan Status Toko
                        </button>
                    </form>
                </div>

                {{-- Paket & Layanan --}}
                <div id="paket-layanan" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Services</span>
                            <h2>Kelola Paket & Layanan</h2>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.services.store') }}" class="admin-setting-form mb-4">
                        @csrf

                        <div>
                            <label>Nama Paket/Layanan</label>
                            <input type="text" name="service_name" placeholder="Contoh: Lipat Saja / Express">
                        </div>

                        <div>
                            <label>Kategori</label>
                            <select name="category">
                                <option value="paket">Paket</option>
                                <option value="layanan">Layanan</option>
                            </select>
                        </div>

                        <div>
                            <label>Harga per Kg</label>
                            <input type="number" name="price_per_kg" placeholder="Contoh: 5000">
                        </div>

                        <button type="submit" class="admin-btn-primary">
                            Tambah
                        </button>
                    </form>

                    <div class="admin-manage-grid">
                        <div class="admin-manage-card">
                            <h3>Paket</h3>

                            <div class="admin-simple-list">
                                @forelse ($packages as $service)
                                    <div class="admin-simple-row">
                                        <div class="admin-service-icon">
                                            <i class="bi {{ $service->icon_class }}"></i>
                                        </div>

                                        <div class="admin-simple-row-info">
                                            <strong>{{ $service->service_name }}</strong>
                                            <span>{{ $service->category_label }} •
                                                Rp{{ number_format($service->price_per_kg, 0, ',', '.') }}/kg</span>
                                        </div>

                                        <button type="button" class="admin-action primary" onclick="openServiceModal(
                                                        '{{ $service->id }}',
                                                        '{{ addslashes($service->service_name) }}',
                                                        '{{ $service->category }}',
                                                        '{{ $service->price_per_kg }}'
                                                    )">
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.services.delete', $service->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="admin-action danger" type="submit"
                                                onclick="return confirm('Hapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="admin-empty-box">
                                        <i class="bi bi-info-circle"></i>
                                        <p>Belum ada data paket.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="admin-manage-card">
                            <h3>Layanan</h3>

                            <div class="admin-simple-list">
                                @forelse ($serviceTypes as $service)
                                    <div class="admin-simple-row">
                                        <div class="admin-service-icon">
                                            <i class="bi {{ $service->icon_class }}"></i>
                                        </div>

                                        <div class="admin-simple-row-info">
                                            <strong>{{ $service->service_name }}</strong>
                                            <span>{{ $service->category_label }} •
                                                Rp{{ number_format($service->price_per_kg, 0, ',', '.') }}/kg</span>
                                        </div>

                                        <button type="button" class="admin-action primary" onclick="openServiceModal(
                                                        '{{ $service->id }}',
                                                        '{{ addslashes($service->service_name) }}',
                                                        '{{ $service->category }}',
                                                        '{{ $service->price_per_kg }}'
                                                    )">
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.services.delete', $service->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="admin-action danger" type="submit"
                                                onclick="return confirm('Hapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="admin-empty-box">
                                        <i class="bi bi-info-circle"></i>
                                        <p>Belum ada data layanan.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wangi --}}
                <div id="wangi" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Fragrance</span>
                            <h2>Kelola Wangi</h2>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.services.store') }}" class="admin-setting-form mb-4">
                        @csrf

                        <input type="hidden" name="category" value="wangi">

                        <div>
                            <label>Nama Wangi</label>
                            <input type="text" name="service_name" placeholder="Contoh: Wangi Bunga">
                        </div>

                        <div>
                            <label>Harga per Kg</label>
                            <input type="number" name="price_per_kg" placeholder="Contoh: 1000" value="0">
                        </div>

                        <button type="submit" class="admin-btn-primary">
                            Tambah Wangi
                        </button>
                    </form>

                    <div class="admin-simple-list">
                        @forelse ($fragrances as $service)
                            <div class="admin-simple-row">
                                <div class="admin-service-icon">
                                    <i class="bi {{ $service->icon_class }}"></i>
                                </div>

                                <div class="admin-simple-row-info">
                                    <strong>{{ $service->service_name }}</strong>
                                    <span>{{ $service->category_label }} •
                                        Rp{{ number_format($service->price_per_kg, 0, ',', '.') }}/kg</span>
                                </div>

                                <button type="button" class="admin-action primary" onclick="openServiceModal(
                                                '{{ $service->id }}',
                                                '{{ addslashes($service->service_name) }}',
                                                '{{ $service->category }}',
                                                '{{ $service->price_per_kg }}'
                                            )">
                                    Edit
                                </button>

                                <form method="POST" action="{{ route('admin.services.delete', $service->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="admin-action danger" type="submit"
                                        onclick="return confirm('Hapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="admin-empty-box">
                                <i class="bi bi-info-circle"></i>
                                <p>Belum ada pilihan wangi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pickup --}}
                <div id="pickup" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Pickup Options</span>
                            <h2>Kelola Opsi Antar Jemput</h2>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.pickup-options.store') }}" class="admin-setting-form mb-4">
                        @csrf

                        <div>
                            <label>Nama Opsi</label>
                            <input type="text" name="name" placeholder="Contoh: Dijemput & Diantar">
                        </div>

                        <div>
                            <label>Kode Opsi</label>
                            <input type="text" name="code" placeholder="Contoh: dijemput_antar">
                        </div>

                        <div>
                            <label>Harga Antar Jemput</label>
                            <input type="number" name="price" placeholder="Contoh: 5000" value="0">
                        </div>

                        <div>
                            <label>Status</label>
                            <select name="is_active">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <div class="admin-setting-full">
                            <label>Deskripsi</label>
                            <textarea name="description" placeholder="Deskripsi opsi antar jemput"></textarea>
                        </div>

                        <button type="submit" class="admin-btn-primary">
                            Tambah Opsi
                        </button>
                    </form>

                    <div class="admin-simple-list">
                        @forelse ($pickupOptions as $option)
                            <div class="admin-simple-row">
                                <div class="admin-service-icon">
                                    <i class="bi bi-truck"></i>
                                </div>

                                <div class="admin-simple-row-info">
                                    <strong>{{ $option->name }}</strong>
                                    <span>
                                        {{ $option->code }}
                                        • {{ $option->is_active ? 'Aktif' : 'Nonaktif' }}
                                        • Rp{{ number_format($option->price ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>

                                <button type="button" class="admin-action primary" onclick="openPickupModal(
                                                '{{ $option->id }}',
                                                '{{ addslashes($option->name) }}',
                                                '{{ addslashes($option->code) }}',
                                                '{{ $option->price ?? 0 }}',
                                                '{{ $option->is_active ? 1 : 0 }}',
                                                '{{ addslashes($option->description ?? '') }}'
                                            )">
                                    Edit
                                </button>

                                <form method="POST" action="{{ route('admin.pickup-options.delete', $option->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="admin-action danger" type="submit"
                                        onclick="return confirm('Hapus opsi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="admin-empty-box">
                                <i class="bi bi-info-circle"></i>
                                <p>Belum ada opsi antar jemput.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
    </section>

    {{-- Modal Edit Service --}}
    <div class="admin-modal" id="serviceEditModal">
        <div class="admin-modal-backdrop" onclick="closeServiceModal()"></div>

        <div class="admin-modal-card">
            <div class="admin-modal-header">
                <div>
                    <span>Edit Data</span>
                    <h3>Edit Paket / Layanan / Wangi</h3>
                </div>

                <button type="button" onclick="closeServiceModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form method="POST" id="serviceEditForm" class="admin-setting-form">
                @csrf
                @method('PATCH')

                <div>
                    <label>Nama</label>
                    <input type="text" name="service_name" id="editServiceName">
                </div>

                <div>
                    <label>Kategori</label>
                    <select name="category" id="editServiceCategory">
                        <option value="paket">Paket</option>
                        <option value="layanan">Layanan</option>
                        <option value="wangi">Wangi</option>
                    </select>
                </div>

                <div>
                    <label>Harga per Kg</label>
                    <input type="number" name="price_per_kg" id="editServicePrice">
                </div>

                <button type="submit" class="admin-btn-primary">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Edit Pickup --}}
    <div class="admin-modal" id="pickupEditModal">
        <div class="admin-modal-backdrop" onclick="closePickupModal()"></div>

        <div class="admin-modal-card">
            <div class="admin-modal-header">
                <div>
                    <span>Edit Opsi</span>
                    <h3>Edit Antar Jemput</h3>
                </div>

                <button type="button" onclick="closePickupModal()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form method="POST" id="pickupEditForm" class="admin-setting-form">
                @csrf
                @method('PATCH')

                <div>
                    <label>Nama Opsi</label>
                    <input type="text" name="name" id="editPickupName">
                </div>

                <div>
                    <label>Kode</label>
                    <input type="text" name="code" id="editPickupCode">
                </div>

                <div>
                    <label>Harga</label>
                    <input type="number" name="price" id="editPickupPrice">
                </div>

                <div>
                    <label>Status</label>
                    <select name="is_active" id="editPickupStatus">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="admin-setting-full">
                    <label>Deskripsi</label>
                    <textarea name="description" id="editPickupDescription"></textarea>
                </div>

                <button type="submit" class="admin-btn-primary">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openServiceModal(id, name, category, price) {
            const modal = document.getElementById('serviceEditModal');
            const form = document.getElementById('serviceEditForm');

            form.action = `/admin/layanan/${id}`;
            document.getElementById('editServiceName').value = name;
            document.getElementById('editServiceCategory').value = category;
            document.getElementById('editServicePrice').value = price;

            modal.classList.add('show');
        }

        function closeServiceModal() {
            document.getElementById('serviceEditModal').classList.remove('show');
        }

        function openPickupModal(id, name, code, price, isActive, description) {
            const modal = document.getElementById('pickupEditModal');
            const form = document.getElementById('pickupEditForm');

            form.action = `/admin/opsi-antar-jemput/${id}`;
            document.getElementById('editPickupName').value = name;
            document.getElementById('editPickupCode').value = code;
            document.getElementById('editPickupPrice').value = price;
            document.getElementById('editPickupStatus').value = String(isActive);
            document.getElementById('editPickupDescription').value = description || '';

            modal.classList.add('show');
        }

        function closePickupModal() {
            document.getElementById('pickupEditModal').classList.remove('show');
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeServiceModal();
                closePickupModal();
            }
        });
    </script>
@endsection
