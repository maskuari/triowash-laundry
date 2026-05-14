@extends('layouts.app')

@section('title', 'Pesan Laundry')

@section('styles')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- Order Page --}}
    <section class="order-page">
        <div class="order-orb order-orb-1"></div>
        <div class="order-orb order-orb-2"></div>

        <div class="container position-relative z-index-1">

            {{-- Step Info --}}
            <div class="order-steps" data-aos="fade-up" data-aos-delay="100">
                <div class="order-step active">
                    <span>1</span>
                    <div>
                        <strong>Isi Data</strong>
                        <small>Nama, nomor, alamat</small>
                    </div>
                </div>

                <div class="order-step">
                    <span>2</span>
                    <div>
                        <strong>Pilih Layanan</strong>
                        <small>Paket, wangi, antar-jemput</small>
                    </div>
                </div>

                <div class="order-step">
                    <span>3</span>
                    <div>
                        <strong>Konfirmasi</strong>
                        <small>Pesanan masuk ke admin</small>
                    </div>
                </div>
            </div>

            <div class="order-layout">
                {{-- Form --}}
                <form class="order-form" id="orderForm" data-aos="fade-right" data-aos-duration="900">
                    @csrf

                    {{-- Data Pelanggan --}}
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            <div>
                                <h2>Data Pelanggan</h2>
                                <p>Tanpa akun, cukup gunakan nama dan nomor telepon.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="customerName" class="order-label">Nama Lengkap</label>
                                <input
                                    type="text"
                                    class="order-input"
                                    id="customerName"
                                    name="customer_name"
                                    placeholder="Contoh: Budi Santoso"
                                >
                                <small class="order-error" data-error="customerName"></small>
                            </div>

                            <div class="col-md-6">
                                <label for="customerPhone" class="order-label">Nomor Telepon</label>
                                <input
                                    type="tel"
                                    class="order-input"
                                    id="customerPhone"
                                    name="customer_phone"
                                    placeholder="Contoh: 081234567890"
                                >
                                <small class="order-error" data-error="customerPhone"></small>
                            </div>

                            <div class="col-12">
                                <label for="customerAddress" class="order-label">Alamat Lengkap</label>
                                <textarea
                                    class="order-input order-textarea"
                                    id="customerAddress"
                                    name="customer_address"
                                    rows="3"
                                    placeholder="Contoh: Jl. Merpati No. 12, Banjarmasin"
                                ></textarea>
                                <small class="order-error" data-error="customerAddress"></small>
                            </div>

                            <div class="col-12">
                                <label for="googleMapsLink" class="order-label">Link Google Maps <span>opsional</span></label>
                                <input
                                    type="url"
                                    class="order-input"
                                    id="googleMapsLink"
                                    name="google_maps_link"
                                    placeholder="https://maps.app.goo.gl/..."
                                >
                                <small class="order-hint">Link Maps membantu kurir menemukan alamat lebih cepat.</small>
                            </div>
                        </div>
                    </div>

                    {{-- Paket Layanan --}}
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-icon">
                                <i class="bi bi-basket3"></i>
                            </div>

                            <div>
                                <h2>Paket Layanan</h2>
                                <p>Pilih jenis pengerjaan utama untuk cucian kamu.</p>
                            </div>
                        </div>

                        <div class="order-option-grid">
                            <label class="order-option-card">
                                <input
                                    type="radio"
                                    name="service_package"
                                    value="setrika_lipat"
                                    data-name="Cuci Komplit"
                                    data-price="5000"
                                    checked
                                >

                                <span class="order-option-icon">
                                    <i class="bi bi-basket3"></i>
                                </span>

                                <strong>Cuci Komplit</strong>
                                <small>Cuci, kering, setrika, dan lipat.</small>
                                <em>Rp5.000/kg</em>
                            </label>

                            <label class="order-option-card">
                                <input
                                    type="radio"
                                    name="service_package"
                                    value="lipat_saja"
                                    data-name="Cuci Kering"
                                    data-price="3000"
                                >

                                <span class="order-option-icon">
                                    <i class="bi bi-wind"></i>
                                </span>

                                <strong>Cuci Kering</strong>
                                <small>Cuci dan kering tanpa setrika.</small>
                                <em>Rp3.000/kg</em>
                            </label>

                            <label class="order-option-card">
                                <input
                                    type="radio"
                                    name="service_package"
                                    value="setrika_saja"
                                    data-name="Setrika Saja"
                                    data-price="4000"
                                >

                                <span class="order-option-icon">
                                    <i class="bi bi-lightning-charge"></i>
                                </span>

                                <strong>Setrika Saja</strong>
                                <small>Pakaian bersih dirapikan.</small>
                                <em>Rp4.000/kg</em>
                            </label>
                        </div>
                    </div>

                    {{-- Pilihan Wangi --}}
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-icon">
                                <i class="bi bi-stars"></i>
                            </div>

                            <div>
                                <h2>Pilihan Wangi</h2>
                                <p>Pilih aroma sesuai preferensi kamu.</p>
                            </div>
                        </div>

                        <div class="order-pill-group">
                            <label class="order-pill">
                                <input
                                    type="radio"
                                    name="perfume"
                                    value="bunga"
                                    data-name="Wangi Bunga"
                                    data-price="1000"
                                    checked
                                >
                                <span>Wangi Bunga</span>
                                <small>+Rp1.000/kg</small>
                            </label>

                            <label class="order-pill">
                                <input
                                    type="radio"
                                    name="perfume"
                                    value="sport"
                                    data-name="Wangi Sport"
                                    data-price="1000"
                                >
                                <span>Wangi Sport</span>
                                <small>+Rp1.000/kg</small>
                            </label>

                            <label class="order-pill">
                                <input
                                    type="radio"
                                    name="perfume"
                                    value="original"
                                    data-name="Wangi Original"
                                    data-price="0"
                                >
                                <span>Original</span>
                                <small>Gratis</small>
                            </label>
                        </div>
                    </div>

                    {{-- Opsi Antar Jemput --}}
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-icon">
                                <i class="bi bi-truck"></i>
                            </div>

                            <div>
                                <h2>Opsi Antar-Jemput</h2>
                                <p>Tentukan bagaimana pakaian diambil dan dikembalikan.</p>
                            </div>
                        </div>

                        <div class="order-delivery-grid">
                            <label class="order-delivery-card">
                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="pickup_delivery"
                                    data-name="Dijemput & Diantar"
                                    checked
                                >
                                <i class="bi bi-truck"></i>
                                <span>Dijemput & Diantar</span>
                                <small>Kurir ambil dan antar kembali.</small>
                            </label>

                            <label class="order-delivery-card">
                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="pickup_only"
                                    data-name="Dijemput Saja"
                                >
                                <i class="bi bi-box-arrow-in-down"></i>
                                <span>Dijemput Saja</span>
                                <small>Kurir hanya mengambil pakaian.</small>
                            </label>

                            <label class="order-delivery-card">
                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="delivery_only"
                                    data-name="Diantar Saja"
                                >
                                <i class="bi bi-box-arrow-up"></i>
                                <span>Diantar Saja</span>
                                <small>Pelanggan antar, kurir mengantar pulang.</small>
                            </label>

                            <label class="order-delivery-card">
                                <input
                                    type="radio"
                                    name="delivery_option"
                                    value="self_service"
                                    data-name="Antar & Ambil Sendiri"
                                >
                                <i class="bi bi-shop"></i>
                                <span>Antar & Ambil Sendiri</span>
                                <small>Cocok untuk pelanggan walk-in.</small>
                            </label>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-icon">
                                <i class="bi bi-chat-left-text"></i>
                            </div>

                            <div>
                                <h2>Catatan Tambahan</h2>
                                <p>Tulis permintaan khusus jika ada.</p>
                            </div>
                        </div>

                        <textarea
                            class="order-input order-textarea"
                            id="orderNote"
                            name="order_note"
                            rows="3"
                            placeholder="Contoh: Tolong pisahkan baju putih dan berwarna."
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary order-submit-button shadow-primary">
                        <i class="bi bi-send-check"></i>
                        Lanjutkan Pemesanan
                    </button>
                </form>

                {{-- Summary --}}
                <aside class="order-summary" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="order-summary-card">
                        <div class="order-summary-header">
                            <span>
                                <i class="bi bi-receipt"></i>
                            </span>

                            <div>
                                <h3>Ringkasan Pesanan</h3>
                                <p>Estimasi awal sebelum penimbangan.</p>
                            </div>
                        </div>

                        <div class="order-summary-list">
                            <div>
                                <span>Nama</span>
                                <strong id="summaryName">Belum diisi</strong>
                            </div>

                            <div>
                                <span>Nomor</span>
                                <strong id="summaryPhone">Belum diisi</strong>
                            </div>

                            <div>
                                <span>Layanan</span>
                                <strong id="summaryService">Cuci Komplit</strong>
                            </div>

                            <div>
                                <span>Wangi</span>
                                <strong id="summaryPerfume">Wangi Bunga</strong>
                            </div>

                            <div>
                                <span>Antar-Jemput</span>
                                <strong id="summaryDelivery">Dijemput & Diantar</strong>
                            </div>
                        </div>

                        <div class="order-summary-price">
                            <span>Estimasi harga per kg</span>
                            <strong id="summaryPrice">Rp6.000/kg</strong>
                        </div>

                        <div class="order-alert">
                            <i class="bi bi-info-circle"></i>
                            <p>
                                Total akhir dihitung setelah pakaian ditimbang oleh admin.
                                Pembayaran dapat dilakukan menggunakan QRIS atau tunai.
                            </p>
                        </div>

                        <div class="order-summary-actions">
                            <a href="/periksa-pesanan" class="order-summary-link">
                                <i class="bi bi-search"></i>
                                Cek pesanan yang sudah dibuat
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        {{-- Demo Success Modal --}}
        <div class="order-modal" id="orderModal" aria-hidden="true">
            <div class="order-modal-backdrop" data-close-modal></div>

            <div class="order-modal-card">
                <button type="button" class="order-modal-close" data-close-modal>
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="order-modal-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <h4>Frontend pemesanan sudah siap</h4>
                <p>
                    Untuk saat ini data belum dikirim ke database karena backend pemesanan akan dibuat setelah ini.
                </p>

                <button type="button" class="btn btn-primary btn-modern" data-close-modal>
                    Mengerti
                </button>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/order.js') }}"></script>
@endsection