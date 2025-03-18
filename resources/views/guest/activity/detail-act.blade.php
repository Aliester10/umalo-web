@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}'); background-position: center; background-repeat: no-repeat; background-size: cover; padding: 60px 0;">
    <div class="container text-center py-5">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.company_activity') }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item active text-primary">{{ __('messages.detail_activity') }}</li>            
        </ol>    
    </div>
</div>
<!-- Header End -->

<!-- Activity Content Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- Kiri: Judul & Deskripsi -->
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.3s">
                <div class="section-title text-start">
                    <h1 class="display-4 mb-4" style="font-weight: bold; color: #2c3e50;">{{ $activity->title }}</h1>
                    <p class="mb-3 text-muted" style="font-size: 1rem;">
                        <i class="fa fa-calendar-alt text-success"></i> {{ $activity->date->format('d M Y') }}
                    </p>
                    <p class="text-justify" style="font-size: 1.1rem; color: #555; line-height: 1.8;">
                        {{ $activity->description }}
                    </p>
                </div>
            </div>

            <!-- Kanan: Gambar -->
            <div class="col-lg-6 text-center wow fadeInRight" data-wow-delay="0.5s">
                <div class="image-container">
                    <img src="{{ asset($activity->images) }}" class="img-fluid rounded shadow-lg animate-img" alt="Activity Image">
                </div>
            </div>
        </div>

        <!-- Tambahan Gambar -->
        @if(isset($activity->additional_images) && count($activity->additional_images) > 0)
            <div class="row g-3 mt-4">
                @foreach($activity->additional_images as $image)
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <img src="{{ asset($image) }}" class="img-fluid rounded shadow-sm" style="object-fit: cover; max-height: 300px;">
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Tombol Kembali -->
        <div class="text-center mt-5 wow fadeInUp" data-wow-delay="0.6s">
            <a href="{{ route('activity') }}" class="btn btn-success px-4 py-2 btn-animate">{{ __('messages.back') }}</a>
        </div>
    </div>
</div>
<!-- Activity Content End -->

<!-- Animasi CSS -->
<style>
    /* Animasi untuk Gambar */
    .animate-img {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s;
    }
    .animate-img:hover {
        transform: scale(1.05);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Tombol Hover */
    .btn-animate {
        transition: all 0.3s ease-in-out;
    }
    .btn-animate:hover {
        background: #28a745;
        color: white;
        transform: scale(1.1);
    }
</style>
@endsection
