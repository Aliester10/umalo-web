@extends('layouts.guest.master')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="text-center">
        <h1 class="display-1 text-danger">500</h1>
        <h2 class="text-warning mb-4">Oops! Terjadi Kesalahan di Server</h2>
        <p class="text-muted mb-4">Maaf, ada sesuatu yang tidak beres di sisi server kami. Kami sedang bekerja untuk memperbaiki masalah ini.</p>
        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill py-3 px-5">Kembali ke Beranda</a>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa; /* Warna latar belakang */
    }
    .text-danger {
        font-size: 10rem; /* Ukuran besar untuk kode 500 */
    }
</style>

@endsection
