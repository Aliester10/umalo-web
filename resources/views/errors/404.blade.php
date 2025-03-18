@extends('layouts.guest.master')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="text-center">
        <h1 class="display-1 text-dangere text-danger">404</h1>
        <h2 class="text-warning mb-4">Oops! Halaman Tidak Ditemukan</h2>
        <p class="text-muted mb-4">Maaf, halaman yang Anda cari tidak ditemukan atau telah dipindahkan.</p>
        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill py-3 px-5">Kembali ke Beranda</a>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa; /* Warna latar belakang */
    }
    .text-dangere {
        font-size: 10rem; /* Ukuran besar untuk kode 404 */
    }
</style>

@endsection
