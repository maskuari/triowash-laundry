@extends('layouts.app')

@section('title', 'Pesan Laundry')

@section('styles')
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
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
                    Isi data singkat, pilih layanan, tentukan lokasi, lalu pesanan akan masuk ke admin Triowash.
                </p>
            </div>

            <div class="order-layout">
                {{-- Form --}}
                <form
                    class="order-form"
                    id="orderForm"
                    method="POST"
                    action="{{ route('order.store') }}"
                    data-backend-ready="true"
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
                                <label for="addressDetail">Detail Alamat</label>
                                <textarea
                                    id="addressDetail"
                                    name="address"
                                    rows="3"
                                    placeholder="Contoh: Jl. Merpati No. 12, RT 05/RW 02, rumah pagar putih"
                                >{{ old('address') }}</textarea>
                                <small class="order-error" data-error="addressDetail">
                                    @error('address') {{ $message }} @enderror
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-card-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div>
                                <h2>Lokasi Pelanggan</h2>
                                <p>Klik peta atau gunakan lokasi saya agar kurir mudah menemukan alamat.</p>
                            </div>
                        </div>

                        <div class="order-map-wrapper">
                            <div class="order-map-header">
                                <div>
                                    <h3>Pilih Titik Lokasi</h3>
                                    <p>Koordinat dan link maps akan disimpan untuk admin/kurir.</p>
                                </div>

                                <button type="button" class="order-location-btn" id="useMyLocationBtn">
                                    <i class="bi bi-geo-alt"></i>
                                    Lokasi Saya
                                </button>
                            </div>

                            <div id="orderMap" class="order-map"></div>

                            <div class="order-location-preview">
                                <div>
                                    <span>Negara</span>
                                    <strong id="previewCountry">Belum dipilih</strong>
                                </div>

                                <div>
                                    <span>Provinsi</span>
                                    <strong id="previewProvince">Belum dipilih</strong>
                                </div>

                                <div>
                                    <span>Kab/Kota</span>
                                    <strong id="previewCity">Belum dipilih</strong>
                                </div>

                                <div>
                                    <span>Kecamatan</span>
                                    <strong id="previewDistrict">Belum dipilih</strong>
                                </div>
                            </div>

                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                            <input type="hidden" id="googleMapsLink" name="google_maps" value="{{ old('google_maps') }}">
                            <input type="hidden" id="country" name="country" value="{{ old('country') }}">
                            <input type="hidden" id="province" name="province" value="{{ old('province') }}">
                            <input type="hidden" id="city" name="city" value="{{ old('city') }}">
                            <input type="hidden" id="district" name="district" value="{{ old('district') }}">
                            <input type="hidden" id="village" name="village" value="{{ old('village') }}">
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
                                        @foreach ($packages as $package)
                                            <option
                                                value="{{ $package->id }}"
                                                data-name="{{ $package->service_name }}"
                                                data-display-name="{{ $package->service_name }}"
                                                data-price="{{ $package->price_per_kg }}"
                                                @selected(old('service_id') == $package->id)
                                            >
                                                {{ $package->service_name }} - Rp{{ number_format($package->price_per_kg, 0, ',', '.') }}/kg
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="order-error">
                                    @error('service_id') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-select-box">
                                <label for="fragranceSelect">Pilihan Wangi</label>
                                <div class="order-select">
                                    <i class="bi bi-stars"></i>
                                    <select id="fragranceSelect" name="fragrance_id">
                                        @forelse ($fragrances as $fragrance)
                                            <option
                                                value="{{ $fragrance->id }}"
                                                data-name="{{ $fragrance->service_name }}"
                                                data-price="{{ $fragrance->price_per_kg }}"
                                                @selected(old('fragrance_id') == $fragrance->id)
                                            >
                                                {{ $fragrance->service_name }}
                                                @if ($fragrance->price_per_kg > 0)
                                                    - Rp{{ number_format($fragrance->price_per_kg, 0, ',', '.') }}/kg
                                                @else
                                                    - Gratis
                                                @endif
                                            </option>
                                        @empty
                                            <option value="" data-name="Tanpa Wangi" data-price="0">Tanpa Wangi</option>
                                        @endforelse
                                    </select>
                                </div>
                                <small class="order-error">
                                    @error('fragrance_id') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="order-select-box full">
                                <label for="pickupSelect">Opsi Antar-Jemput</label>
                                <div class="order-select">
                                    <i class="bi bi-truck"></i>
                                    <select id="pickupSelect" name="pickup_option_id">
                                        @foreach ($pickupOptions as $pickupOption)
                                            <option
                                                value="{{ $pickupOption->id }}"
                                                data-name="{{ $pickupOption->name }}"
                                                @selected(old('pickup_option_id') == $pickupOption->id)
                                            >
                                                {{ $pickupOption->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="order-error">
                                    @error('pickup_option_id') {{ $message }} @enderror
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
                                <strong id="summaryService">-</strong>
                            </div>

                            <div>
                                <span>Wangi</span>
                                <strong id="summaryPerfume">-</strong>
                            </div>

                            <div>
                                <span>Antar-Jemput</span>
                                <strong id="summaryDelivery">-</strong>
                            </div>
                        </div>

                        <div class="order-summary-price">
                            <span>Estimasi harga per kg</span>
                            <strong id="summaryPrice">Rp0/kg</strong>
                        </div>

                        <div class="order-alert">
                            <i class="bi bi-info-circle"></i>
                            <p>
                                Total akhir dihitung setelah pakaian ditimbang oleh admin.
                                Pembayaran dapat dilakukan menggunakan QRIS atau tunai.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('js/order.js') }}"></script>
@endsection