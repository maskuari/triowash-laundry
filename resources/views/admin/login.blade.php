@extends('layouts.admin')

@section('title', 'Login Admin')

@section('content')
    <section class="admin-auth-page">
        <div class="admin-auth-shell">
            <div class="admin-auth-brand">
                <a href="{{ route('home') }}" class="admin-auth-logo">
                    <img
                        src="{{ asset('assets/images/logo.png') }}"
                        alt="Triowash"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
                    >
                    <span>triowash</span>
                </a>

                <div class="admin-auth-copy">
                    <span class="admin-eyebrow">Admin Area</span>
                    <h1>Masuk ke Sistem Admin</h1>
                    <p>Kelola pesanan, layanan, pembayaran, dan status operasional Triowash.</p>
                </div>

                <div class="admin-auth-status">
                    <i class="bi bi-shield-lock-fill"></i>
                    <div>
                        <strong>Akses internal</strong>
                        <span>Area operasional Triowash.</span>
                    </div>
                </div>
            </div>

            <div class="admin-auth-card">
                <div class="admin-auth-card-header">
                    <i class="bi bi-person-lock"></i>
                    <div>
                        <span>Login Admin</span>
                        <h2>Verifikasi Akun</h2>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success rounded-4 fw-bold mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger rounded-4 fw-bold mb-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-auth-form">
                    @csrf

                    <label for="email">Email Admin</label>
                    <div class="admin-auth-field">
                        <i class="bi bi-envelope-fill"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="triowash@admin.co.id"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>

                    <label for="password">Password</label>
                    <div class="admin-auth-field">
                        <i class="bi bi-key-fill"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button type="submit" class="admin-auth-submit">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk Admin
                    </button>
                </form>

                <a href="{{ route('home') }}" class="admin-auth-back">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>
@endsection
