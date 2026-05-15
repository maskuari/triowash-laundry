@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="admin-page">
        <aside class="admin-sidebar">
            <a href="/admin" class="admin-brand">
                <img
                    src="{{ asset('assets/images/logo.png') }}"
                    alt="Triowash"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
                >
                <span>triowash</span>
            </a>

            <nav class="admin-menu">
                <a href="#dashboard" class="admin-menu-link active">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
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

                <a href="#layanan" class="admin-menu-link">
                    <i class="bi bi-basket2-fill"></i>
                    <span>Layanan</span>
                </a>

                <a href="#pickup" class="admin-menu-link">
                    <i class="bi bi-truck"></i>
                    <span>Antar Jemput</span>
                </a>
            </nav>

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
                    <p>Pesanan dipisah berdasarkan status supaya data tidak menumpuk dalam satu daftar.</p>
                </div>

                <form method="GET" action="{{ route('admin.dashboard') }}" class="admin-topbar-actions">
                    <div class="admin-search">
                        <i class="bi bi-search"></i>
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari kode pesanan, nama, nomor..."
                            value="{{ $search ?? '' }}"
                        >
                    </div>

                    <button class="admin-btn-primary" type="submit">
                        Cari
                    </button>

                    @if (!empty($search))
                        <a href="{{ route('admin.dashboard') }}" class="admin-btn-secondary text-decoration-none">
                            Reset
                        </a>
                    @endif
                </form>
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
                {{-- Pesanan Masuk --}}
                <div id="masuk" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Incoming</span>
                            <h2>Pesanan Masuk</h2>
                        </div>
                    </div>

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
                                        $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
                                    @endphp

                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_code }}</strong>
                                            <small class="d-block text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                        </td>

                                        <td>
                                            <div class="admin-customer">
                                                <span>{{ $order->customer->name }}</span>
                                                <small>{{ $order->customer->phone }}</small>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $mainService?->service_name ?? '-' }}
                                            @if ($fragrance)
                                                <small class="d-block text-muted">{{ $fragrance->service_name }}</small>
                                            @endif
                                        </td>

                                        <td>{{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}</td>

                                        <td>
                                            <span class="admin-badge warning">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="admin-badge {{ $order->payment_status === 'paid' ? 'done' : 'warning' }}">
                                                {{ $order->payment_status_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="admin-table-actions">
                                                <form method="POST" action="{{ route('admin.orders.approve', $order->order_code) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="admin-action success" type="submit">ACC</button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.orders.reject', $order->order_code) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="admin-action danger"
                                                        type="submit"
                                                        onclick="return confirm('Tolak pesanan ini? Pesanan akan otomatis terhapus.')"
                                                    >
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

                {{-- Pesanan Diproses --}}
                <div id="diproses" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Process</span>
                            <h2>Pesanan Diproses</h2>
                        </div>
                    </div>

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
                                @php
                                    $processedOrders = collect($approvedOrders)->merge($activeOrders);
                                @endphp

                                @forelse ($processedOrders as $order)
                                    @php
                                        $mainService = $order->orderItems->firstWhere('service.category', 'paket')?->service;
                                        $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
                                    @endphp

                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_code }}</strong>
                                            <small class="d-block text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                        </td>

                                        <td>
                                            <div class="admin-customer">
                                                <span>{{ $order->customer->name }}</span>
                                                <small>{{ $order->customer->phone }}</small>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $mainService?->service_name ?? '-' }}
                                            @if ($fragrance)
                                                <small class="d-block text-muted">{{ $fragrance->service_name }}</small>
                                            @endif
                                        </td>

                                        <td>{{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}</td>

                                        <td>
                                            <span class="admin-badge process">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="admin-badge {{ $order->payment_status === 'paid' ? 'done' : 'warning' }}">
                                                {{ $order->payment_status_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->order_code) }}" class="admin-action primary text-decoration-none">
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

                {{-- Pesanan Selesai --}}
                <div id="selesai" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Done</span>
                            <h2>Pesanan Selesai</h2>
                        </div>
                    </div>

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
                                        $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
                                    @endphp

                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_code }}</strong>
                                            <small class="d-block text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                        </td>

                                        <td>
                                            <div class="admin-customer">
                                                <span>{{ $order->customer->name }}</span>
                                                <small>{{ $order->customer->phone }}</small>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $mainService?->service_name ?? '-' }}
                                            @if ($fragrance)
                                                <small class="d-block text-muted">{{ $fragrance->service_name }}</small>
                                            @endif
                                        </td>

                                        <td>{{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}</td>

                                        <td>
                                            <span class="admin-badge done">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="admin-badge {{ $order->payment_status === 'paid' ? 'done' : 'warning' }}">
                                                {{ $order->payment_status_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="admin-table-actions">
                                                <a href="{{ route('admin.orders.show', $order->order_code) }}" class="admin-action primary text-decoration-none">
                                                    Detail
                                                </a>

                                                <form method="POST" action="{{ route('admin.orders.delete', $order->order_code) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="admin-action danger"
                                                        type="submit"
                                                        onclick="return confirm('Hapus data pesanan selesai ini?')"
                                                    >
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

                {{-- Layanan --}}
                <div id="layanan" class="admin-panel admin-panel-full">
                    <div class="admin-panel-header">
                        <div>
                            <span>Services</span>
                            <h2>Kelola Layanan & Wangi</h2>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.services.store') }}" class="admin-setting-form mb-4">
                        @csrf

                        <div>
                            <label>Nama Layanan/Wangi</label>
                            <input type="text" name="service_name" placeholder="Contoh: Cuci Komplit">
                        </div>

                        <div>
                            <label>Kategori</label>
                            <select name="category">
                                <option value="paket">Paket Layanan</option>
                                <option value="wangi">Pilihan Wangi</option>
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

                    <div class="admin-service-list">
                        @foreach ($services as $service)
                            <div class="admin-service-item">
                                <div class="admin-service-icon">
                                    <i class="bi {{ $service->category === 'paket' ? 'bi-basket3' : 'bi-stars' }}"></i>
                                </div>

                                <div>
                                    <strong>{{ $service->service_name }}</strong>
                                    <span>{{ ucfirst($service->category) }} • Rp{{ number_format($service->price_per_kg, 0, ',', '.') }}/kg</span>
                                </div>

                                <form method="POST" action="{{ route('admin.services.delete', $service->id) }}" class="ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus layanan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
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

                        <div class="admin-setting-full">
                            <label>Deskripsi</label>
                            <textarea name="description" placeholder="Deskripsi opsi antar jemput"></textarea>
                        </div>

                        <div>
                            <label>Status</label>
                            <select name="is_active">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <button type="submit" class="admin-btn-primary">
                            Tambah Opsi
                        </button>
                    </form>

                    <div class="admin-service-list">
                        @foreach ($pickupOptions as $option)
                            <div class="admin-service-item">
                                <div class="admin-service-icon">
                                    <i class="bi bi-truck"></i>
                                </div>

                                <div>
                                    <strong>{{ $option->name }}</strong>
                                    <span>{{ $option->code }} • {{ $option->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </div>

                                <form method="POST" action="{{ route('admin.pickup-options.delete', $option->id) }}" class="ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus opsi ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </section>
@endsection