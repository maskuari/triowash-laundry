@extends('layouts.app')

@section('title', 'Periksa Pesanan')

@section('styles')
    <link href="{{ asset('css/tracking.css') }}" rel="stylesheet">
@endsection

@php
    $currentStatus = $order?->status;
    $statusOrder = collect($trackingSteps)->pluck('status')->toArray();
    $currentIndex = $currentStatus ? array_search($currentStatus, $statusOrder, true) : false;

    $mainService = $order?->orderItems?->firstWhere('service.category', 'paket')?->service;
    $fragrance = $order?->orderItems?->firstWhere('service.category', 'wangi')?->service;
@endphp

@section('content')
    <section class="tracking-page">
        <div class="tracking-bg tracking-bg-1"></div>
        <div class="tracking-bg tracking-bg-2"></div>

        <div class="container position-relative z-index-1">
            <div class="tracking-layout">
                {{-- Form --}}
                <div class="tracking-hero" data-aos="fade-right" data-aos-duration="900">
                    <div class="tracking-badge">
                        <i class="bi bi-search-heart"></i>
                        Periksa Pesanan
                    </div>

                    <h1>
                        Cek status laundry
                        <span>tanpa login.</span>
                    </h1>

                    <p>
                        Masukkan nama dan nomor telepon yang digunakan saat pemesanan.
                        Sistem akan menampilkan status terbaru pesanan laundry kamu.
                    </p>

                    <form class="tracking-form" id="trackingForm" method="POST" action="{{ route('tracking.search') }}">
                        @csrf

                        <div class="tracking-field">
                            <i class="bi bi-person"></i>
                            <input
                                type="text"
                                name="name"
                                id="customerName"
                                placeholder="Contoh: Budi Santoso"
                                autocomplete="off"
                                value="{{ old('name') }}"
                            >
                        </div>

                        @error('name')
                            <small class="tracking-error">{{ $message }}</small>
                        @enderror

                        <div class="tracking-field">
                            <i class="bi bi-telephone"></i>
                            <input
                                type="text"
                                name="phone"
                                id="customerPhone"
                                placeholder="Contoh: 081234567890"
                                autocomplete="off"
                                value="{{ old('phone') }}"
                            >
                        </div>

                        @error('phone')
                            <small class="tracking-error">{{ $message }}</small>
                        @enderror

                        <button type="submit">
                            <i class="bi bi-search"></i>
                            Cek Pesanan
                        </button>
                    </form>
                </div>

                {{-- Result --}}
                <div class="tracking-card" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="tracking-card-head">
                        <div>
                            <span>Tracking Order</span>
                            <h2>Detail Pesanan</h2>
                        </div>

                        <div class="tracking-head-icon">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                    </div>

                    @if ($order)
                        <div class="tracking-result" id="trackingResult">
                            <div class="tracking-order">
                                <div>
                                    <span>Kode Pesanan</span>
                                    <strong>{{ $order->order_code }}</strong>
                                </div>

                                <small>{{ $order->status_label }}</small>
                            </div>

                            <div class="tracking-data">
                                <div>
                                    <span>Nama</span>
                                    <strong>{{ $order->customer->name }}</strong>
                                </div>

                                <div>
                                    <span>No. Telepon</span>
                                    <strong>{{ $order->customer->phone }}</strong>
                                </div>

                                <div>
                                    <span>Layanan</span>
                                    <strong>{{ $mainService?->service_name ?? '-' }}</strong>
                                </div>

                                <div>
                                    <span>Wangi</span>
                                    <strong>{{ $fragrance?->service_name ?? '-' }}</strong>
                                </div>

                                <div>
                                    <span>Antar Jemput</span>
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
                                    <span>Pembayaran</span>
                                    <strong>{{ $order->payment_status_label }}</strong>
                                </div>
                            </div>

                            <div class="tracking-title">
                                <i class="bi bi-arrow-repeat"></i>
                                Progress Pesanan
                            </div>

                            <div class="tracking-timeline">
                                @foreach ($trackingSteps as $index => $step)
                                    @php
                                        $isDone = $currentIndex !== false && $index < $currentIndex;
                                        $isCurrent = $currentStatus === $step['status'];

                                        $stepClass = '';
                                        if ($isDone) {
                                            $stepClass = 'done';
                                        }
                                        if ($isCurrent) {
                                            $stepClass = 'current';
                                        }
                                    @endphp

                                    <div class="tracking-step {{ $stepClass }}">
                                        <i class="bi {{ $isDone ? 'bi-check-lg' : $step['icon'] }}"></i>
                                        <div>
                                            <strong>{{ $step['label'] }}</strong>
                                            <span>{{ $step['description'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tracking-payment">
                                <div>
                                    <span>Status Pembayaran</span>
                                    <strong>{{ $order->payment_status_label }}</strong>
                                </div>

                                @if ($order->payment_status === \App\Models\Order::PAYMENT_UNPAID && $order->total_price > 0)
                                   <a href="{{ route('payment.pay', $order->order_code) }}" class="tracking-pay-link">
                                        <i class="bi bi-qr-code"></i>
                                        Bayar
                                    </a>
                                @else
                                    <span class="tracking-payment-note">
                                        {{ $order->total_price > 0 ? 'Tidak perlu pembayaran.' : 'Menunggu hasil timbang.' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @elseif ($searched)
                        <div class="tracking-empty" id="trackingEmpty">
                            <div class="tracking-empty-icon">
                                <i class="bi bi-search"></i>
                            </div>

                            <h5>Pesanan Tidak Ditemukan</h5>
                            <p>
                                Tidak ditemukan pesanan dengan nama dan nomor tersebut.
                                Pastikan data yang dimasukkan sudah benar.
                            </p>
                        </div>
                    @else
                        <div class="tracking-empty" id="trackingEmpty">
                            <div class="tracking-empty-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>

                            <h5>Masukkan Data Pesanan</h5>
                            <p>
                                Isi nama dan nomor telepon untuk melihat status pesanan laundry kamu.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection