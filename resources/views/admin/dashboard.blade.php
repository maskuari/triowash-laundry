@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- Admin Dashboard --}}
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

                <a href="#pesanan" class="admin-menu-link">
                    <i class="bi bi-inbox-fill"></i>
                    <span>Pesanan Masuk</span>
                    <small>{{ $stats['incoming_orders'] ?? 0 }}</small>
                </a>

                <a href="#timbang" class="admin-menu-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Proses Timbang</span>
                </a>

                <a href="#pembayaran" class="admin-menu-link">
                    <i class="bi bi-cash-stack"></i>
                    <span>Pembayaran</span>
                </a>

                <a href="#layanan" class="admin-menu-link">
                    <i class="bi bi-basket2-fill"></i>
                    <span>Layanan/Wangi</span>
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
            {{-- Flash Message --}}
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

            {{-- Topbar --}}
            <header class="admin-topbar">
                <div>
                    <span class="admin-eyebrow">Dashboard Admin</span>
                    <h1>Selamat datang, Admin Triowash</h1>
                    <p>Kelola pesanan, timbang cucian, pembayaran, layanan, dan opsi antar jemput.</p>
                </div>

                <div class="admin-topbar-actions">
                    <div class="admin-search">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Cari kode pesanan, nama, nomor..." id="adminSearchInput">
                    </div>

                    <div class="admin-profile">
                        <div class="admin-profile-avatar">A</div>
                        <div>
                            <strong>Admin</strong>
                            <small>Operator Toko</small>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Summary --}}
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
                    <div class="admin-summary-icon cyan">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <span>Perlu Dijemput</span>
                        <strong>{{ $stats['pickup_orders'] ?? 0 }}</strong>
                        <small>Menunggu kurir</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon purple">
                        <i class="bi bi-droplet-half"></i>
                    </div>
                    <div>
                        <span>Sedang Diproses</span>
                        <strong>{{ $stats['processing_orders'] ?? 0 }}</strong>
                        <small>Dalam pengerjaan</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon green">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <span>Pendapatan Hari Ini</span>
                        <strong>Rp{{ number_format($stats['today_revenue'] ?? 0, 0, ',', '.') }}</strong>
                        <small>{{ $stats['paid_orders'] ?? 0 }} pesanan lunas</small>
                    </div>
                </div>
            </section>

            <section class="admin-content-grid">
                {{-- Pesanan --}}
                <div id="pesanan" class="admin-panel admin-panel-large">
                    <div class="admin-panel-header">
                        <div>
                            <span>Order Queue</span>
                            <h2>Daftar Pesanan</h2>
                        </div>

                        <a href="/pesan" class="admin-btn-primary text-decoration-none">
                            <i class="bi bi-plus-lg"></i>
                            Tambah Pesanan
                        </a>
                    </div>

                    <div class="admin-table-wrapper">
                        <table class="admin-table" id="adminOrderTable">
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
                                @forelse ($orders as $order)
                                    @php
                                        $mainService = $order->orderItems->firstWhere('service.category', 'paket')?->service;
                                        $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
                                    @endphp

                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_code }}</strong>
                                            <small class="d-block text-muted">
                                                {{ $order->created_at->format('d M Y') }}
                                            </small>
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

                                        <td>
                                            {{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="admin-badge {{ $order->status === 'dibatalkan' ? 'danger' : ($order->status === 'selesai_diterima' ? 'done' : 'process') }}">
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
                                                @if ($order->status === \App\Models\Order::STATUS_MENUNGGU_VERIFIKASI)
                                                    <form method="POST" action="{{ route('admin.orders.approve', $order->order_code) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="admin-action success" type="submit">ACC</button>
                                                    </form>

                                                    <form method="POST" action="{{ route('admin.orders.reject', $order->order_code) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="admin-action danger" type="submit">Tolak</button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('admin.orders.show', $order->order_code) }}" class="admin-action primary text-decoration-none">
                                                    Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted fw-bold py-4">
                                            Belum ada pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Status --}}
                <div id="status" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Workflow</span>
                            <h2>Status Pesanan</h2>
                        </div>
                    </div>

                    <div class="admin-status-list">
                        <div class="admin-status-item active">
                            <i class="bi bi-clock"></i>
                            <div>
                                <strong>Menunggu Verifikasi</strong>
                                <span>Pesanan baru masuk</span>
                            </div>
                            <small>{{ $stats['incoming_orders'] ?? 0 }}</small>
                        </div>

                        <div class="admin-status-item">
                            <i class="bi bi-truck"></i>
                            <div>
                                <strong>Dijemput</strong>
                                <span>Kurir menjemput pakaian</span>
                            </div>
                            <small>{{ $stats['pickup_orders'] ?? 0 }}</small>
                        </div>

                        <div class="admin-status-item">
                            <i class="bi bi-droplet"></i>
                            <div>
                                <strong>Aktif Diproses</strong>
                                <span>Pesanan sedang berjalan</span>
                            </div>
                            <small>{{ $stats['processing_orders'] ?? 0 }}</small>
                        </div>

                        <div class="admin-status-item">
                            <i class="bi bi-cash-stack"></i>
                            <div>
                                <strong>Belum Dibayar</strong>
                                <span>Menunggu pembayaran</span>
                            </div>
                            <small>{{ $stats['unpaid_orders'] ?? 0 }}</small>
                        </div>
                    </div>
                </div>

                {{-- Proses Timbang --}}
                <div id="timbang" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Weight Input</span>
                            <h2>Proses Timbang</h2>
                        </div>
                    </div>

                    <form class="admin-weight-form" method="POST" action="#" id="adminWeightForm">
                        @csrf
                        @method('PATCH')

                        <label>Kode Pesanan</label>
                        <select id="weightOrderSelect">
                            <option value="">Pilih Pesanan</option>
                            @foreach ($orders as $order)
                                <option
                                    value="{{ route('admin.orders.weight', $order->order_code) }}"
                                    data-total="{{ $order->total_price }}"
                                >
                                    {{ $order->order_code }} - {{ $order->customer->name }}
                                </option>
                            @endforeach
                        </select>

                        <label>Berat Cucian</label>
                        <div class="admin-input-group">
                            <input type="number" name="weight" step="0.1" placeholder="Contoh: 3.5">
                            <span>Kg</span>
                        </div>

                        <button type="submit" class="admin-btn-primary w-100">
                            Simpan Berat & Hitung Harga
                        </button>
                    </form>
                </div>

                {{-- Pembayaran --}}
                <div id="pembayaran" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Payment</span>
                            <h2>Pembayaran Tunai</h2>
                        </div>
                    </div>

                    <form class="admin-weight-form" method="POST" action="#" id="adminCashForm">
                        @csrf

                        <label>Pesanan</label>
                        <select id="cashOrderSelect">
                            <option value="">Pilih Pesanan</option>
                            @foreach ($paymentOrders as $order)
                                <option value="{{ route('admin.orders.cash-payment', $order->order_code) }}">
                                    {{ $order->order_code }} - Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>

                        <label>Nominal Uang Diterima</label>
                        <div class="admin-input-group">
                            <input type="number" name="cash_received" placeholder="Contoh: 25000">
                            <span>Rp</span>
                        </div>

                        <button type="submit" class="admin-btn-primary w-100">
                            Konfirmasi Bayar Tunai
                        </button>
                    </form>

                    <small class="d-block mt-3 text-muted fw-bold">
                        Pembayaran QRIS akan otomatis lunas setelah Midtrans callback/webhook aktif.
                    </small>
                </div>

                {{-- Layanan / Wangi --}}
                <div id="layanan" class="admin-panel admin-panel-large">
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

                {{-- Opsi Antar Jemput --}}
                <div id="pickup" class="admin-panel admin-panel-large">
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

@section('scripts')
    <script>
        const weightSelect = document.getElementById('weightOrderSelect');
        const weightForm = document.getElementById('adminWeightForm');

        weightSelect?.addEventListener('change', () => {
            if (weightSelect.value) {
                weightForm.action = weightSelect.value;
            }
        });

        const cashSelect = document.getElementById('cashOrderSelect');
        const cashForm = document.getElementById('adminCashForm');

        cashSelect?.addEventListener('change', () => {
            if (cashSelect.value) {
                cashForm.action = cashSelect.value;
            }
        });

        const searchInput = document.getElementById('adminSearchInput');
        const rows = document.querySelectorAll('#adminOrderTable tbody tr');

        searchInput?.addEventListener('input', () => {
            const keyword = searchInput.value.toLowerCase();

            rows.forEach((row) => {
                row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
            });
        });
    </script>
@endsection