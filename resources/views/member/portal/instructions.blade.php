@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 60px 0; transition: 0.5s;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.user_manual') }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal') }}">{{ __('messages.member_portal') }}</a></li>
            <li class="breadcrumb-item">{{ __('messages.user_manual') }}</li>
        </ol> 
    </div>
</div>
<!-- Header End -->

<!-- Instructions Start -->
<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            @forelse($uniqueProduks as $produk)
                <div class="col-md-4 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-img rounded-top shadow" style="border-radius: 10px;">
                        <img src="{{ asset($produk->images->first()->gambar ?? 'assets/img/default.jpg') }}" class="img-fluid rounded-top w-100" alt="{{ $produk->nama }}">
                        <div class="service-content-inner p-4" style="border-radius: 0 0 10px 10px;">
                            <h5>{{ $produk->nama }}</h5>
                            @if($produk->user_manual)
                            <a href="{{ asset($produk->user_manual) }}" download="{{ $produk->nama }}_manual.pdf" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">{{ __('messages.download_manual') }}</a>
                            <a href="{{ asset($produk->user_manual) }}" class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2" target="_blank">{{ __('messages.view_manual') }}</a>
                            
                            @else
                            <p class="text-muted">{{ __('messages.no_manual') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">{{ __('messages.no_product') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <div style="text-align: center;">
        <a class="btn btn-primary rounded-pill mt-5 mb-5 wow fadeInDown" data-wow-delay="0.5s" href="javascript:history.back()">{{ __('messages.back') }}</a>
    </div>
</div>
<!-- Instructions End -->
@endsection
