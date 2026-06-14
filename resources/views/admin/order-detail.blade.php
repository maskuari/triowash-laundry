@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@php
    $mainService = $order->orderItems->firstWhere('service.category', 'paket')?->service;
    $fragrance = $order->orderItems->firstWhere('service.category', 'wangi')?->service;
    $isLocked = $order->status === \App\Models\Order::STATUS_SELESAI_DITERIMA;

    $cleanPhone = preg_replace('/\D/', '', $order->customer->phone ?? '');

    if (substr($cleanPhone, 0, 1) === '0') {
        $waPhone = '62' . substr($cleanPhone, 1);
    } elseif (substr($cleanPhone, 0, 2) === '62') {
        $waPhone = $cleanPhone;
    } elseif (substr($cleanPhone, 0, 1) === '8') {
        $waPhone = '62' . $cleanPhone;
    } else {
        $waPhone = $cleanPhone;
    }

    $waMessage = rawurlencode(
        'Halo ' . $order->customer->name . ', kami dari Triowash. Kami ingin memberitahukan informasi terbaru terkait pesanan laundry kamu dengan kode ' . $order->order_code . '. Silakan balas pesan ini jika ingin bertanya atau membutuhkan bantuan. Terima kasih.'
    );

    $waUrl = $waPhone ? 'https://wa.me/' . $waPhone . '?text=' . $waMessage : null;
@endphp

@section('content')
    <section class="admin-page">
        <aside class="admin-sidebar">
            <a href="/admin" class="admin-brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Triowash"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                <span>triowash</span>
            </a>

            <nav class="admin-menu">
                <a href="/admin" class="admin-menu-link">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali Dashboard</span>
                </a>

                <a href="#detail" class="admin-menu-link active">
                    <i class="bi bi-receipt"></i>
                    <span>Detail Pesanan</span>
                </a>

                <a href="#status" class="admin-menu-link">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Update Status</span>
                </a>

                <a href="#payment" class="admin-menu-link">
                    <i class="bi bi-cash-stack"></i>
                    <span>Pembayaran</span>
                </a>
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}" class="admin-sidebar-logout">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Keluar Admin</span>
                </button>
            </form>
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

            @if ($isLocked)
                <div class="alert alert-info rounded-4 fw-bold mb-3">
                    Pesanan ini sudah selesai diterima pelanggan. Data status, berat, dan pembayaran tidak bisa diubah lagi.
                </div>
            @endif

            <header class="admin-topbar">
                <div>
                    <span class="admin-eyebrow">Detail Pesanan</span>
                    <h1>{{ $order->order_code }}</h1>
                    <p>Kelola detail pesanan, status, berat cucian, dan pembayaran pelanggan.</p>
                </div>

                <div class="admin-topbar-actions">
                    <a href="/admin" class="admin-btn-secondary text-decoration-none">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </header>

            <section class="admin-content-grid">
                <div id="detail" class="admin-panel admin-panel-large">
                    <div class="admin-panel-header">
                        <div>
                            <span>Customer</span>
                            <h2>Data Pelanggan</h2>
                        </div>

                        <span class="admin-badge {{ $isLocked ? 'done' : 'process' }}">
                            {{ $order->status_label }}
                        </span>
                    </div>

                    <div class="admin-detail-grid">
                        <div>
                            <span>Nama</span>
                            <strong>{{ $order->customer->name }}</strong>
                        </div>

                        <div>
                            <span>No. Telepon</span>
                            <strong>{{ $order->customer->phone }}</strong>

                            @if ($waUrl)
                                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="admin-wa-link">
                                    <i class="bi bi-whatsapp"></i>
                                    Hubungi WhatsApp
                                </a>
                            @endif
                        </div>

                        <div class="admin-detail-full">
                            <span>Alamat</span>
                            <strong>{{ $order->customer->address }}</strong>
                        </div>

                        <div>
                            <span>Negara</span>
                            <strong>{{ $order->customer->country ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Provinsi</span>
                            <strong>{{ $order->customer->province ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Kota/Kabupaten</span>
                            <strong>{{ $order->customer->city ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Kecamatan/Desa</span>
                            <strong>{{ $order->customer->district ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Koordinat</span>
                            <strong>
                                @if ($order->customer->latitude && $order->customer->longitude)
                                    {{ $order->customer->latitude }}, {{ $order->customer->longitude }}
                                @else
                                    -
                                @endif
                            </strong>
                        </div>

                        <div>
                            <span>Google Maps</span>
                            @if ($order->customer->google_maps)
                                <a href="{{ $order->customer->google_maps }}" target="_blank" class="admin-detail-link">
                                    Buka Maps
                                </a>
                            @else
                                <strong>-</strong>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Order</span>
                            <h2>Ringkasan</h2>
                        </div>
                    </div>

                    <div class="admin-detail-list">
                        <div>
                            <span>Layanan</span>
                            <strong>{{ $mainService?->service_name ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Wangi</span>
                            <strong>{{ $fragrance?->service_name ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Opsi Antar Jemput</span>
                            <strong>{{ $order->pickup_option_name ?? $order->pickupOption?->name ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Berat</span>
                            <strong>{{ $order->weight ? $order->weight . ' Kg' : 'Belum ditimbang' }}</strong>
                        </div>

                        <div>
                            <span>Total Harga</span>
                            <strong>
                                @if ($order->total_price > 0)
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                @else
                                    Belum dihitung
                                @endif
                            </strong>
                        </div>

                        <div>
                            <span>Status Pembayaran</span>
                            <strong>{{ $order->payment_status_label }}</strong>
                        </div>

                        <div>
                            <span>Catatan</span>
                            <strong>{{ $order->notes ?: '-' }}</strong>
                        </div>
                    </div>
                </div>

                <div id="status" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Action</span>
                            <h2>Aksi Pesanan</h2>
                        </div>
                    </div>

                    @if ($isLocked)
                        <div class="admin-empty-box">
                            <i class="bi bi-lock-fill"></i>
                            <p>Pesanan sudah selesai diterima. Aksi pesanan tidak bisa diubah lagi.</p>
                        </div>
                    @else
                        <div class="admin-action-stack">
                            @if ($order->status === \App\Models\Order::STATUS_MENUNGGU_VERIFIKASI)
                                <form method="POST" action="{{ route('admin.orders.approve', $order->order_code) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-btn-primary w-100">
                                        ACC Pesanan
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.orders.reject', $order->order_code) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-btn-danger w-100">
                                        Tolak / Batalkan Pesanan
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.orders.status', $order->order_code) }}">
                                @csrf
                                @method('PATCH')

                                <label>Update Status</label>
                                <select name="status">
                                    <option value="menunggu_verifikasi" @selected($order->status === 'menunggu verifikasi')>
                                        Menunggu Verifikasi</option>
                                    <option value="dijemput" @selected($order->status === 'dijemput')>Dijemput</option>
                                    <option value="diproses" @selected($order->status === 'diproses')>Diproses</option>
                                    <option value="menunggu_pembayaran" @selected($order->status === 'menunggu pembayaran')>
                                        Menunggu Pembayaran</option>
                                    <option value="selesai" @selected($order->status === 'selesai')>Selesai</option>
                                    <option value="diantar" @selected($order->status === 'diantar')>Diantar</option>
                                    <option value="selesai_diterima" @selected($order->status === 'selesai_diterima')>Selesai
                                        Diterima</option>
                                    <option value="dibatalkan" @selected($order->status === 'dibatalkan')>Dibatalkan</option>
                                </select>

                                <button type="submit" class="admin-btn-primary w-100 mt-2">
                                    Simpan Status
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div id="weight" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Weight</span>
                            <h2>Input Berat</h2>
                        </div>
                    </div>

                    @if ($isLocked)
                        <div class="admin-empty-box">
                            <i class="bi bi-lock-fill"></i>
                            <p>Berat cucian sudah dikunci karena pesanan selesai diterima.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('admin.orders.weight', $order->order_code) }}"
                            class="admin-weight-form">
                            @csrf
                            @method('PATCH')

                            <label>Berat Cucian</label>
                            <div class="admin-input-group">
                                <input type="number" name="weight" step="0.1" value="{{ old('weight', $order->weight) }}"
                                    placeholder="Contoh: 3.5">
                                <span>Kg</span>
                            </div>

                            <button type="submit" class="admin-btn-primary w-100">
                                Simpan Berat & Hitung Harga
                            </button>
                        </form>
                    @endif
                </div>

                <div id="payment" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Payment</span>
                            <h2>Bayar Tunai</h2>
                        </div>
                    </div>

                    @if ($isLocked)
                        <div class="admin-empty-box">
                            <i class="bi bi-lock-fill"></i>
                            <p>Pembayaran sudah dikunci karena pesanan selesai diterima.</p>
                        </div>
                    @elseif ($order->total_price > 0 && $order->payment_status === \App\Models\Order::PAYMENT_UNPAID)
                        <form method="POST" action="{{ route('admin.orders.cash-payment', $order->order_code) }}"
                            class="admin-weight-form">
                            @csrf

                            <label>Total Harga</label>
                            <div class="admin-price-preview">
                                <span>Tagihan</span>
                                <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </div>

                            <label>Nominal Uang Diterima</label>
                            <div class="admin-input-group">
                                <input type="number" name="cash_received" placeholder="Contoh: 25000">
                                <span>Rp</span>
                            </div>

                            <button type="submit" class="admin-btn-primary w-100">
                                Konfirmasi Bayar Tunai
                            </button>
                        </form>
                    @else
                        <div class="admin-empty-box">
                            <i class="bi bi-info-circle"></i>
                            <p>
                                @if ($order->payment_status === \App\Models\Order::PAYMENT_PAID)
                                    Pesanan ini sudah dibayar.
                                @else
                                    Total harga belum dihitung. Input berat cucian terlebih dahulu.
                                @endif
                            </p>
                        </div>
                    @endif

                    <small class="d-block mt-3 text-muted fw-bold">
                        Jika pelanggan bayar QRIS, status pembayaran nanti akan otomatis lunas melalui Midtrans callback.
                    </small>
                </div>

                <div class="admin-panel admin-panel-large">
                    <div class="admin-panel-header">
                        <div>
                            <span>History</span>
                            <h2>Riwayat Status</h2>
                        </div>
                    </div>

                    <div class="admin-status-list admin-history-clean">
                        @forelse ($order->statusLogs->sortByDesc('created_at') as $log)
                            <div class="admin-status-item">
                                <i class="bi bi-clock-history"></i>
                                <div>
                                    <strong>{{ $log->new_status }}</strong>
                                    <span>
                                        {{ $log->description ?? 'Status pesanan diperbarui.' }}
                                        <br>
                                        {{ $log->created_at->format('d M Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="admin-empty-box">
                                <i class="bi bi-info-circle"></i>
                                <p>Belum ada riwayat status.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
    </section>
@endsection
