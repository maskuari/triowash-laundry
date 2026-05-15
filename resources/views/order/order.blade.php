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
            <div class="order-header" data-aos="fade-up">
                <span class="order-eyebrow">
                    <i class="bi bi-bag-heart"></i>
                    Pesan Laundry
                </span>

                <h1>
                    Pesan laundry
                    <span>tanpa ribet.</span>
                </h1>

                <p>
                    Isi data singkat, pilih layanan, lalu pesanan akan masuk ke admin Triowash untuk dikonfirmasi.
                </p>
            </div>

            <div class="order-layout">
                {{-- Form --}}
                <form
                    class="order-form"
                    id="orderForm"
                    method="POST"
                    action="/pesan"
                    data-aos="fade-right"
                    data-aos-duration="900"
                >
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

                        <div class="order-form-grid">
                            <div class="order-field">
                                <label for="customerName">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="customerName"
                                    name="name"
                                    placeholder="Contoh: Budi Santoso"
                                    value="{{ old('name') }}"
                                >
                                <small class="order-error" data-error="customerName">
                                    @error('name') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-field">
                                <label for="customerPhone">Nomor Telepon</label>
                                <input
                                    type="tel"
                                    id="customerPhone"
                                    name="phone"
                                    placeholder="Contoh: 081234567890"
                                    value="{{ old('phone') }}"
                                >
                                <small class="order-error" data-error="customerPhone">
                                    @error('phone') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-field full">
                                <label for="customerAddress">Alamat Lengkap</label>
                                <textarea
                                    id="customerAddress"
                                    name="address"
                                    rows="3"
                                    placeholder="Contoh: Jl. Merpati No. 12, Banjarmasin"
                                >{{ old('address') }}</textarea>
                                <small class="order-error" data-error="customerAddress">
                                    @error('address') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-field full">
                                <label for="googleMapsLink">
                                    Link Google Maps
                                    <span>opsional</span>
                                </label>
                                <input
                                    type="url"
                                    id="googleMapsLink"
                                    name="google_maps"
                                    placeholder="https://maps.app.goo.gl/..."
                                    value="{{ old('google_maps') }}"
                                >
                                <small class="order-hint">Link Maps membantu kurir menemukan alamat lebih cepat.</small>
                            </div>
                        </div>
                    </div>

                    {{-- Pilihan Pesanan --}}
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-icon">
                                <i class="bi bi-basket3"></i>
                            </div>

                            <div>
                                <h2>Detail Pesanan</h2>
                                <p>Pilih layanan, wangi, dan opsi antar jemput.</p>
                            </div>
                        </div>

                        <div class="order-select-grid">
                            <div class="order-select-box">
                                <label for="serviceSelect">Paket Layanan</label>
                                <div class="order-select">
                                    <i class="bi bi-basket3"></i>
                                    <select id="serviceSelect" name="service_id">
                                        <option value="1" data-name="Setrika + Lipat" data-display-name="Cuci Komplit" data-price="5000">
                                            Cuci Komplit - Rp5.000/kg
                                        </option>
                                        <option value="2" data-name="Lipat Saja" data-display-name="Cuci Kering" data-price="3000">
                                            Cuci Kering - Rp3.000/kg
                                        </option>
                                        <option value="3" data-name="Setrika Saja" data-display-name="Setrika Saja" data-price="4000">
                                            Setrika Saja - Rp4.000/kg
                                        </option>
                                    </select>
                                </div>
                                <small class="order-error" data-error="service_id">
                                    @error('service_id') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-select-box">
                                <label for="fragranceSelect">Pilihan Wangi</label>
                                <div class="order-select">
                                    <i class="bi bi-stars"></i>
                                    <select id="fragranceSelect" name="fragrance_id">
                                        <option value="4" data-name="Wangi Bunga" data-price="1000">
                                            Wangi Bunga - Rp1.000/kg
                                        </option>
                                        <option value="5" data-name="Wangi Sport" data-price="1000">
                                            Wangi Sport - Rp1.000/kg
                                        </option>
                                        <option value="6" data-name="Wangi Original" data-price="0">
                                            Original - Gratis
                                        </option>
                                    </select>
                                </div>
                                <small class="order-error" data-error="fragrance_id">
                                    @error('fragrance_id') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-select-box full">
                                <label for="pickupSelect">Opsi Antar-Jemput</label>
                                <div class="order-select">
                                    <i class="bi bi-truck"></i>
                                    <select id="pickupSelect" name="pickup_type">
                                        <option value="dijemput_antar" data-name="Dijemput & Diantar">
                                            Dijemput & Diantar
                                        </option>
                                        <option value="dijemput_saja" data-name="Dijemput Saja">
                                            Dijemput Saja
                                        </option>
                                        <option value="diantar_saja" data-name="Diantar Saja">
                                            Diantar Saja
                                        </option>
                                        <option value="antar_ambil_sendiri" data-name="Antar & Ambil Sendiri">
                                            Antar & Ambil Sendiri
                                        </option>
                                    </select>
                                </div>
                                <small class="order-error" data-error="pickup_type">
                                    @error('pickup_type') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-field full">
                                <label for="orderNote">Catatan Tambahan <span>opsional</span></label>
                                <textarea
                                    id="orderNote"
                                    name="notes"
                                    rows="3"
                                    placeholder="Contoh: Tolong pisahkan baju putih dan berwarna."
                                >{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="order-mobile-summary">
                        <div>
                            <span>Estimasi harga per kg</span>
                            <strong id="mobileSummaryPrice">Rp6.000/kg</strong>
                        </div>
                        <small>Total akhir dihitung setelah cucian ditimbang admin.</small>
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

                <h4>Form pemesanan sudah siap</h4>
                <p>
                    Struktur field sudah disesuaikan untuk backend. Setelah controller dibuat,
                    data akan disimpan ke database.
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