@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" 
    style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/about_banner.jpg') }}'); 
    position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; 
    background-size: cover; padding: 20px 0; transition: 0.5s;">
    
    <div class="container text-center py-3" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.faq') }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">{{ __('messages.home') }}</a>
            </li>
            <li class="breadcrumb-item text-white">{{ __('messages.faqs') }}</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- FAQs Start -->
<div class="container-fluid faq-section bg-light py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="h-100">
                    <div class="mb-5">
                        <h4 class="text-primary">{{ __('messages.some_important_faqs') }}</h4>
                        <h1 class="display-4 mb-0">{{ __('messages.common_faq') }}</h1>                        
                    </div>
                    <div class="accordion" id="accordionExample">
                        @foreach($faqs as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                    <button class="accordion-button border-0" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" 
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                        aria-controls="collapse{{ $loop->index }}">
                                        Q: {{ $faq->questions }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $loop->index }}" 
                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                    aria-labelledby="heading{{ $loop->index }}" 
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body rounded">
                                        A: {{ $faq->answers }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                <div class="contact-img">
                    <div class="contact-img-inner">
                        <img src="{{ asset($company->logo?? 'assets/img/logo.png') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FAQs End -->
@endsection
