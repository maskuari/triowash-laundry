@extends('layouts.app')

@section('content')

<div class="text-center">

    <h1 class="fw-bold mb-4">
        Selamat Datang di Triowash Laundry
    </h1>

    <p class="lead mb-5">
        Laundry antar jemput modern, cepat, dan praktis.
    </p>

    <div class="d-flex justify-content-center gap-3">

        <a href="/order" class="btn btn-primary btn-lg">
            Pesan Sekarang
        </a>

        <a href="/tracking" class="btn btn-outline-primary btn-lg">
            Cek Pesanan
        </a>

    </div>

</div>

@endsection