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
                    <small>8</small>
                </a>

                <a href="#timbang" class="admin-menu-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Proses Timbang</span>
                </a>

                <a href="#status" class="admin-menu-link">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Status Pesanan</span>
                </a>

                <a href="#layanan" class="admin-menu-link">
                    <i class="bi bi-basket2-fill"></i>
                    <span>Manajemen Layanan</span>
                </a>

                <a href="#laporan" class="admin-menu-link">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Laporan</span>
                </a>

                <a href="#setting" class="admin-menu-link">
                    <i class="bi bi-gear-fill"></i>
                    <span>Setting Toko</span>
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
            {{-- Topbar --}}
            <header class="admin-topbar">
                <div>
                    <span class="admin-eyebrow">Dashboard Admin</span>
                    <h1>Selamat datang, Admin Triowash</h1>
                    <p>Kelola pesanan, status, pembayaran, layanan, dan laporan toko dari satu tempat.</p>
                </div>

                <div class="admin-topbar-actions">
                    <div class="admin-search">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Cari kode pesanan, nama, nomor...">
                    </div>

                    <button class="admin-icon-btn">
                        <i class="bi bi-bell"></i>
                        <span></span>
                    </button>

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
                        <strong>18</strong>
                        <small>+6 hari ini</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon cyan">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <span>Perlu Dijemput</span>
                        <strong>7</strong>
                        <small>Menunggu kurir</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon purple">
                        <i class="bi bi-droplet-half"></i>
                    </div>
                    <div>
                        <span>Sedang Diproses</span>
                        <strong>12</strong>
                        <small>Dalam pengerjaan</small>
                    </div>
                </div>

                <div class="admin-summary-card">
                    <div class="admin-summary-icon green">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <span>Pendapatan Hari Ini</span>
                        <strong>Rp450K</strong>
                        <small>15 transaksi</small>
                    </div>
                </div>
            </section>

            {{-- Content Grid --}}
            <section class="admin-content-grid">
                {{-- Pesanan Masuk --}}
                <div id="pesanan" class="admin-panel admin-panel-large">
                    <div class="admin-panel-header">
                        <div>
                            <span>Order Queue</span>
                            <h2>Pesanan Masuk</h2>
                        </div>

                        <button class="admin-btn-primary">
                            <i class="bi bi-plus-lg"></i>
                            Tambah Pesanan
                        </button>
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><strong>TWO-001</strong></td>
                                    <td>
                                        <div class="admin-customer">
                                            <span>Budi Santoso</span>
                                            <small>081234567890</small>
                                        </div>
                                    </td>
                                    <td>Cuci Komplit</td>
                                    <td>Dijemput-Antar</td>
                                    <td><span class="admin-badge warning">Menunggu ACC</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-action success">ACC</button>
                                            <button class="admin-action danger">Tolak</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>TWO-002</strong></td>
                                    <td>
                                        <div class="admin-customer">
                                            <span>Citra Dewi</span>
                                            <small>087812345678</small>
                                        </div>
                                    </td>
                                    <td>Cuci Kering</td>
                                    <td>Antar-Ambil Sendiri</td>
                                    <td><span class="admin-badge info">Dijemput</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-action primary">Detail</button>
                                            <button class="admin-action dark">Timbang</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>TWO-003</strong></td>
                                    <td>
                                        <div class="admin-customer">
                                            <span>Rahmat Hidayat</span>
                                            <small>082156789012</small>
                                        </div>
                                    </td>
                                    <td>Setrika Saja</td>
                                    <td>Diantar Saja</td>
                                    <td><span class="admin-badge process">Diproses</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-action primary">Detail</button>
                                            <button class="admin-action success">Selesai</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>TWO-004</strong></td>
                                    <td>
                                        <div class="admin-customer">
                                            <span>Nadia Putri</span>
                                            <small>085678901234</small>
                                        </div>
                                    </td>
                                    <td>Cuci Komplit</td>
                                    <td>Dijemput-Antar</td>
                                    <td><span class="admin-badge done">Selesai</span></td>
                                    <td>
                                        <div class="admin-table-actions">
                                            <button class="admin-action primary">Detail</button>
                                            <button class="admin-action dark">Antar</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Workflow --}}
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
                            <small>8</small>
                        </div>

                        <div class="admin-status-item">
                            <i class="bi bi-truck"></i>
                            <div>
                                <strong>Dijemput</strong>
                                <span>Kurir menjemput pakaian</span>
                            </div>
                            <small>7</small>
                        </div>

                        <div class="admin-status-item">
                            <i class="bi bi-droplet"></i>
                            <div>
                                <strong>Diproses</strong>
                                <span>Pakaian sedang dikerjakan</span>
                            </div>
                            <small>12</small>
                        </div>

                        <div class="admin-status-item">
                            <i class="bi bi-check2-circle"></i>
                            <div>
                                <strong>Selesai</strong>
                                <span>Menunggu diantar/diambil</span>
                            </div>
                            <small>5</small>
                        </div>

                        <div class="admin-status-item">
                            <i class="bi bi-box-seam"></i>
                            <div>
                                <strong>Selesai Diterima</strong>
                                <span>Pesanan diterima pelanggan</span>
                            </div>
                            <small>21</small>
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

                    <form class="admin-weight-form">
                        <label>Kode Pesanan</label>
                        <select>
                            <option>TWO-001 - Budi Santoso</option>
                            <option>TWO-002 - Citra Dewi</option>
                            <option>TWO-003 - Rahmat Hidayat</option>
                        </select>

                        <label>Berat Cucian</label>
                        <div class="admin-input-group">
                            <input type="number" step="0.1" placeholder="Contoh: 3.5">
                            <span>Kg</span>
                        </div>

                        <label>Layanan</label>
                        <select>
                            <option>Cuci Komplit - Rp5.000/kg</option>
                            <option>Cuci Kering - Rp3.000/kg</option>
                            <option>Setrika Saja - Rp4.000/kg</option>
                        </select>

                        <label>Wangi</label>
                        <select>
                            <option>Wangi Bunga - Rp1.000/kg</option>
                            <option>Wangi Sport - Rp1.000/kg</option>
                            <option>Wangi Original - Gratis</option>
                        </select>

                        <div class="admin-price-preview">
                            <span>Estimasi Total</span>
                            <strong>Rp21.000</strong>
                        </div>

                        <button type="button" class="admin-btn-primary w-100">
                            Simpan Berat & Hitung Harga
                        </button>
                    </form>
                </div>

                {{-- Pembayaran --}}
                <div class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Payment</span>
                            <h2>Pembayaran</h2>
                        </div>
                    </div>

                    <div class="admin-payment-list">
                        <div class="admin-payment-item">
                            <div>
                                <strong>TWO-001</strong>
                                <span>Rp21.000</span>
                            </div>
                            <small class="admin-badge warning">Unpaid</small>
                        </div>

                        <div class="admin-payment-item">
                            <div>
                                <strong>TWO-002</strong>
                                <span>Rp10.000</span>
                            </div>
                            <small class="admin-badge done">Paid</small>
                        </div>

                        <div class="admin-payment-item">
                            <div>
                                <strong>TWO-003</strong>
                                <span>Rp17.500</span>
                            </div>
                            <small class="admin-badge warning">Unpaid</small>
                        </div>
                    </div>

                    <div class="admin-payment-actions">
                        <button class="admin-action success">Bayar Tunai</button>
                        <button class="admin-action primary">Generate QRIS</button>
                    </div>
                </div>

                {{-- Manajemen Layanan --}}
                <div id="layanan" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Services</span>
                            <h2>Manajemen Layanan</h2>
                        </div>

                        <button class="admin-icon-btn small">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>

                    <div class="admin-service-list">
                        <div class="admin-service-item">
                            <div class="admin-service-icon">
                                <i class="bi bi-basket3"></i>
                            </div>
                            <div>
                                <strong>Cuci Komplit</strong>
                                <span>Rp5.000/kg</span>
                            </div>
                            <button><i class="bi bi-pencil"></i></button>
                        </div>

                        <div class="admin-service-item">
                            <div class="admin-service-icon">
                                <i class="bi bi-wind"></i>
                            </div>
                            <div>
                                <strong>Cuci Kering</strong>
                                <span>Rp3.000/kg</span>
                            </div>
                            <button><i class="bi bi-pencil"></i></button>
                        </div>

                        <div class="admin-service-item">
                            <div class="admin-service-icon">
                                <i class="bi bi-lightning"></i>
                            </div>
                            <div>
                                <strong>Setrika Saja</strong>
                                <span>Rp4.000/kg</span>
                            </div>
                            <button><i class="bi bi-pencil"></i></button>
                        </div>

                        <div class="admin-service-item">
                            <div class="admin-service-icon">
                                <i class="bi bi-stars"></i>
                            </div>
                            <div>
                                <strong>Wangi Bunga</strong>
                                <span>Rp1.000/kg</span>
                            </div>
                            <button><i class="bi bi-pencil"></i></button>
                        </div>
                    </div>
                </div>

                {{-- Laporan --}}
                <div id="laporan" class="admin-panel">
                    <div class="admin-panel-header">
                        <div>
                            <span>Reports</span>
                            <h2>Laporan Pendapatan</h2>
                        </div>
                    </div>

                    <div class="admin-report-card">
                        <div>
                            <span>Hari Ini</span>
                            <strong>Rp450.000</strong>
                        </div>
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                    <div class="admin-chart-placeholder">
                        <div style="height: 55%"></div>
                        <div style="height: 75%"></div>
                        <div style="height: 42%"></div>
                        <div style="height: 88%"></div>
                        <div style="height: 64%"></div>
                        <div style="height: 95%"></div>
                        <div style="height: 72%"></div>
                    </div>

                    <button class="admin-btn-secondary w-100">
                        Lihat Laporan Lengkap
                    </button>
                </div>

                {{-- Setting Toko --}}
                <div id="setting" class="admin-panel admin-panel-large">
                    <div class="admin-panel-header">
                        <div>
                            <span>Store Settings</span>
                            <h2>Setting Toko</h2>
                        </div>
                    </div>

                    <form class="admin-setting-form">
                        <div>
                            <label>Nama Toko</label>
                            <input type="text" value="Triowash Laundry">
                        </div>

                        <div>
                            <label>Nomor WhatsApp</label>
                            <input type="text" value="+62 812-3456-7890">
                        </div>

                        <div>
                            <label>Alamat Toko</label>
                            <input type="text" value="Banjarmasin, Kalimantan Selatan">
                        </div>

                        <div>
                            <label>Jam Operasional</label>
                            <input type="text" value="08.00 - 21.00 WITA">
                        </div>

                        <div class="admin-setting-full">
                            <label>Catatan Toko</label>
                            <textarea>Pastikan semua pesanan ditimbang sebelum total harga ditampilkan kepada pelanggan.</textarea>
                        </div>

                        <button type="button" class="admin-btn-primary">
                            Simpan Pengaturan
                        </button>
                    </form>
                </div>
            </section>
        </main>
    </section>
@endsection