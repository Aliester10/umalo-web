@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 60px 0; transition: 0.5s;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.user_products') }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal') }}">{{ __('messages.member_portal') }}</a></li>
            <li class="breadcrumb-item">{{ __('messages.user_products') }}</li>
        </ol>        
    </div>
</div>
<!-- Header End -->

<!-- Main Content Start -->
<div class="container py-5 mb-5">
    <div class="row g-4">
        @forelse($produks as $produk)
            <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                    <img src="{{ asset($produk->produk->images->first()->gambar ?? 'assets/img/default.jpg') }}" class="card-img-top" alt="{{ $produk->produk->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produk->produk->nama }}</h5>
                        <small class="text-muted"><strong>{{ __('messages.purchase_date') }}:</strong> {{ $produk->pembelian ?? 'N/A' }}</small>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('user-product.show', $produk->produk->id) }}" class="btn btn-primary rounded-pill">{{ __('messages.view_details') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p class="mb-0">{{ __('messages.no_product') }}</p>
                    <p class="mb-0">{{ __('messages.no_products_admin') }}</p>
                </div>
            </div>
        @endforelse
    </div>

    <div style="text-align: center;">
        <a class="btn btn-primary rounded-pill mt-5 wow fadeInDown" data-wow-delay="0.5s" href="javascript:history.back()">{{ __('messages.back') }}</a>
    </div>
    
</div>
<!-- Main Content End -->

@endsection
