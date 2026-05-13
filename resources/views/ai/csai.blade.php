@extends('layouts.app')

@section('title', 'AI Customer Service')

@section('styles')
    <link href="{{ asset('css/csai.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- AI Customer Service --}}
    <section class="csai-page">
        <div class="csai-orb csai-orb-1"></div>
        <div class="csai-orb csai-orb-2"></div>

        <div class="container position-relative z-index-1">
            <div class="csai-layout">
                {{-- Intro --}}
                <div class="csai-intro" data-aos="fade-right" data-aos-duration="900">
                    <div class="csai-badge">
                        <i class="bi bi-robot"></i>
                        AI Customer Service
                    </div>

                    <h1>
                        Tanya apa saja
                        <span>seputar Triowash.</span>
                    </h1>

                    <p>
                        Asisten AI siap membantu pelanggan mendapatkan informasi layanan laundry,
                        antar jemput, estimasi pengerjaan, cara pemesanan, pembayaran, dan cek pesanan.
                    </p>

                    <div class="csai-feature-list">
                        <div class="csai-feature-item">
                            <i class="bi bi-chat-dots"></i>
                            <span>Menjawab pertanyaan pelanggan</span>
                        </div>

                        <div class="csai-feature-item">
                            <i class="bi bi-bag-check"></i>
                            <span>Mengarahkan ke halaman pemesanan</span>
                        </div>

                        <div class="csai-feature-item">
                            <i class="bi bi-shield-check"></i>
                            <span>Memiliki backup lokal saat API limit</span>
                        </div>
                    </div>
                </div>

                {{-- Chat Box --}}
                <div class="csai-chat-card" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
                    <div class="csai-chat-header">
                        <div class="csai-avatar">
                            <i class="bi bi-robot"></i>
                        </div>

                        <div>
                            <h5>Triowash AI</h5>
                            <span>
                                <i class="bi bi-circle-fill"></i>
                                Online
                            </span>
                        </div>
                    </div>

                    <div class="csai-chat-body" id="csaiChatBody">
                        <div class="csai-message ai">
                            <div class="csai-message-avatar">
                                <i class="bi bi-robot"></i>
                            </div>

                            <div class="csai-message-content">
                                <p>
                                    Halo! Saya AI Customer Service Triowash. Saya bisa bantu menjelaskan layanan,
                                    cara pesan, antar jemput, pembayaran, dan cek pesanan.
                                </p>
                                <small>Baru saja</small>
                            </div>
                        </div>

                        <div class="csai-quick-actions" id="csaiQuickActions">
                            <button type="button" data-message="Apa saja layanan Triowash?">Layanan Triowash</button>
                            <button type="button" data-message="Apakah bisa antar jemput?">Antar jemput</button>
                            <button type="button" data-message="Bagaimana cara pesan laundry?">Cara pesan</button>
                            <button type="button" data-message="Bagaimana cara cek pesanan?">Cek pesanan</button>
                            <button type="button" data-message="Metode pembayarannya apa saja?">Pembayaran</button>
                        </div>
                    </div>

                    <form class="csai-chat-form" id="csaiChatForm">
                        @csrf

                        <input
                            type="text"
                            id="csaiInput"
                            placeholder="Tulis pertanyaan kamu..."
                            autocomplete="off"
                        >

                        <button type="submit" aria-label="Kirim pesan">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        window.csaiConfig = {
            endpoint: "{{ route('csai.chat') }}",
            csrfToken: "{{ csrf_token() }}",
        };
    </script>

    <script src="{{ asset('js/csai.js') }}"></script>
@endsection