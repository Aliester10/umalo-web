@extends('layouts.guest.master')

@section('content')

<!-- Carousel Start -->
<div class="header-carousel owl-carousel">
    @if ($sliders->isEmpty())
    <div class="header-carousel-item bg-primary" style="background-image: url('{{ asset('assets/img/default_about.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="carousel-caption text-start"> <!-- Added text-center here -->
                        <div class="container">
                            <div class="row g-4 align-items-center justify-content-center"> <!-- Added justify-content-center -->
                                <div class="col-lg-12 animated fadeInLeft">
                                    <div class="text-start"> <!-- Changed to text-center -->
                                        <h4 class="text-white text-uppercase fw-bold mb-4">{{ __('messages.welcome') }}</h4>
                                        <h1 class="display-1 text-white mb-4">{{ __('messages.slogan') }}</h1>
                                        <div class="d-flex justify-content-start flex-shrink-0 mb-4 mt-5"> <!-- Centered buttons -->
                                            <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ route('about') }}">{{ __('messages.explore_services') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            @else
                @foreach ($sliders as $slider)
                    <div class="header-carousel-item bg-primary" style="background-image: url('{{ asset($slider->image_url) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                        <div class="carousel-caption text-start"> <!-- Added text-center here -->
                            <div class="container">
                                <div class="row g-4 align-items-center justify-content-center"> <!-- Added justify-content-center -->
                                    <div class="col-lg-12 animated fadeInLeft">
                                        <div class="text-start"> <!-- Changed to text-center -->
                                            <h4 class="text-white text-uppercase fw-bold">{{ $slider->subtitle }}</h4>
                                            <h1 class="display-1 text-white">{{ $slider->title }}</h1>
                                            <p class="fs-5">{{ $slider->description }}</p>
                                            <div class="d-flex justify-content-start flex-shrink-0"> <!-- Centered buttons -->
                                                <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ $slider->button_url }}">{{ $slider->button_text }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- Carousel End -->

        <style>
        .header-carousel .owl-nav .owl-prev,
        .header-carousel .owl-nav .owl-next {
            display: none !important;
        }
        </style>


        <!-- Product Start -->
        @if (!$products->isEmpty())
        <div class="container-fluid product py-5 mb-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ __('messages.our_products') }}</h4>
                    <h1 class="display-4 mb-4">{{ __('messages.best_products') }}</h1>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach ($products as $product)
                    <div class="col-6 col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                            <div class="product-item shadow-sm border rounded overflow-hidden" style="height: 100%; display: flex; flex-direction: column;">
                            <div class="product-img position-relative" style="height: 200px; overflow: hidden;">
                                <img src="{{ asset($product->images->first()->images ?? 'https://via.placeholder.com/300x200?text=Product+1') }}" 
                                class="img-fluid w-100 h-100" 
                                style="object-fit: cover;" 
                                alt="{{ $product->name }}">
                                <!-- Verified Label -->
                                <span class="product-verified">
                                    <i class="fas fa-check-circle"></i> Umalo
                                </span>
                            </div>
                            <div class="product-content p-3 d-flex flex-column justify-content-between" style="flex-grow: 1;">
                                <!-- Full Product Name -->
                                <h5 class="product-title mb-2" style="font-size: 1rem; font-weight: 600;">
                                    {{ $product->name }}
                                </h5>
                                <p class="text-muted small mb-3">
                                    {{ Str::limit($product->usage, 60) }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a class="btn btn-primary btn-sm py-3 px-5 mt-5" href="{{ route('product.index') }}">
                        {{ __('messages.more_products') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Product end -->

                        <style>
                            .product-item {
                                transition: transform 0.2s, box-shadow 0.2s;
                                height: 100%; /* Ensures cards are always the same height */
                                position: relative;
                            }
                            
                            .product-item:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                            }
                            
                            .product-img img {
                                transition: transform 0.2s ease-in-out;
                            }
                            
                            .product-item:hover .product-img img {
                                transform: scale(1.05);
                            }
                            
                            .product-title {
                                line-height: 1.4;
                                word-wrap: break-word;
                            }
                            
                            /* Verified Label */
                            .product-verified {
                                position: absolute;
                                top: 10px;
                                right: 10px;
                                background-color:#107C10;
                                color: #fff;
                                padding: 5px 10px;
                                font-size: 0.75rem;
                                font-weight: bold;
                                border-radius: 15px;
                                display: none; /* Hidden by default */
                                align-items: center;
                                gap: 5px;
                            }
                            
                            .product-item:hover .product-verified {
                                display: flex; /* Show on hover */
                            }
                        
                            </style>
                            
        

<!-- About Start -->
<div class="container-fluid bg-light about mb-5">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <!-- Image Section -->
            <div class="col-xl-6 wow fadeInRight about-image" data-wow-delay="0.2s" order-xl-2>
                <div class="rounded p-2 h-100 overflow-hidden">
                    <img src="{{ $company && $company->about_gambar ? asset('storage/' . $company->about_gambar) : asset('assets/img/About.png') }}" class="img-fluid rounded w-100 h-100" style="object-fit: cover;" alt="About Image">
                </div>
            </div>

            <!-- Content Section -->
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s" order-xl-1>
                <div class="about-item-content rounded p-5 h-100">
                    <h4>{{ $company->slogan ?? 'Way To Know' }}</h4>
                    <h1 class="display-4 mb-4 text-primary">{{ $company->compay_name ?? 'Umalo Sedia Tekno' }}</h1>
                    <p>{{ $company->short_history ?? 'PT. Umalo Sedia Tekno is an industry leader in providing innovative IT solutions and smart technology systems. Established in 2023, we specialize in integrating cutting-edge technologies to streamline operations, enhance security, and foster innovation across various industries. Our commitment to excellence and innovation has positioned us at the forefront of the smart technology revolution' }}</p>
                    <a class="btn btn-primary btn-sm py-3 px-5 mt-5" href="{{ route('about') }}">{{ __('messages.company_info') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<style>
    /* Adjustments for tablets */
    @media (max-width: 991px) {
        .about .row {
            flex-direction: column-reverse;
        }
        .about-item-content {
            padding: 0px;
        }
        .about {
            padding: 30px 15px; /* Adjust padding for smaller devices */
        }
    }

    /* Adjustments for mobile devices */
    @media (max-width: 767px) {
        .about .row {
            flex-direction: column-reverse;
        }
        .about-item-content h1 {
            font-size: 2.5rem; /* Reduce the size of the title on small screens */
        }
        .about-item-content {
            padding: 15px;
        }
        /* Hide the image on mobile */
        .about-image {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .about .row {
            flex-direction: column-reverse;
        }
        .about-item-content h1 {
            font-size: 2rem;
        }
        .about-item-content p {
            font-size: 1rem;
        }
        .about {
            padding: 20px 10px;
        }
        .about-item-content a.btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Activity Section -->
<div class="container-fluid2 bg-light py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ __('messages.activities_title') }}</h4>
                    <h1 class="display-4 mb-4">{{ __('messages.activities_sub_title') }}</h1>
                </div>
    <div class="container">
        <div class="row g-4 justify-content-center flex-column-reverse flex-lg-row text-center text-lg-start">
            <!-- Content Section -->
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="activity-item-content rounded p-4 h-100">
                    <h5 class="text-uppercase text-muted">Way To Know</h5>
                    <h1 class="text-success fw-bold">{{ $activities[0]->title }}</h1>
                    <p class="text-muted">{{ $activities[0]->description }}</p>
                    <p class="text-primary small mb-3">{{ $activities[0]->date }}</p>
                    <a href="{{ route('activity') }}" class="btn btn-success btn-sm py-3 px-5 mt-4">
                        {{ __('messages.activities_btn') }}
                    </a>
                </div>
            </div>

            <!-- Image Section -->
            <div class="col-xl-6 wow fadeInRight activity-image" data-wow-delay="0.2s">
                <div class="rounded p-2 h-100 overflow-hidden">
                    <img src="{{ $activities[0]->images }}" class="img-fluid rounded w-100 h-100" style="object-fit: cover;" alt="Activity Image">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Activity Section -->

<style>

    .container-fluid2.bg-light {
    background-color: #ffffff !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .activity-item-content {
            text-align: center;
            padding: 0px;
        }
        .container-fluid {
            padding: 30px 15px;
        }
    }

    @media (max-width: 767px) {
        .activity-item-content h1 {
            font-size: 2.5rem;
        }
        .activity-item-content p {
            font-size: 1.1rem;
        }
        .activity-image {
            display: none; /* Hide image on small screens */
        }
    }

    @media (max-width: 576px) {
        .activity-item-content h1 {
            font-size: 2rem;
        }
        .activity-item-content p {
            font-size: 1rem;
        }
        .container-fluid {
            padding: 20px 10px;
        }
        .activity-item-content a.btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }
</style>


<!-- Service Start -->
<div class="container-fluid service py-5 mb-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ __('messages.services_subtitle') }}</h4>
                    <h1 class="display-4 mb-4">{{ __('messages.services_title') }}</h1>
                    <p class="mb-0">{{ __('messages.services_description') }}</p>        
                </div>

                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/iot.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                                <div class="service-icon p-3">
                                    <i class="fa fa-network-wired fa-2x"></i>
                                </div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="d-inline-block h4 mb-4">{{ __('messages.iot_integration') }}</a>
                                    <p class="mb-4">{{ __('messages.iot_description') }}</p>
                                </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/ai.png') }}" class="img-fluid rounded-top w-100" alt="">
                                <div class="service-icon p-3">
                                    <i class="fa fa-robot fa-2x"></i>
                                </div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="d-inline-block h4 mb-4">{{ __('messages.ai_solutions') }}</a>
                                    <p class="mb-4">{{ __('messages.ai_description') }}</p>
                                </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/cyber.png') }}" class="img-fluid rounded-top w-100" alt="">
                                <div class="service-icon p-3">
                                    <i class="fa fa-lock fa-2x"></i>
                                </div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="d-inline-block h4 mb-4">{{ __('messages.cybersecurity') }}</a>
                                    <p class="mb-4">{{ __('messages.cybersecurity_description') }}</p>
                                </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="service-item">
                            <div class="service-img position-relative">
                                <span class="badge bg-primary text-white position-absolute" style="top: 10px; left: 10px; z-index: 1;">{{ __('messages.most_popular') }}</span>
                                <img src="{{ asset('assets/img/labor.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                                <div class="service-icon p-3">
                                    <i class="fa fa-microscope fa-2x"></i>
                                </div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="d-inline-block h4 mb-4">{{ __('messages.labor_simulator') }}</a>
                                    <p class="mb-4">{{ __('messages.labor_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row g-4 justify-content-center mt-3">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/smart.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                                <div class="service-icon p-3">
                                    <i class="fa fa-cogs fa-2x"></i>
                                </div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="d-inline-block h4 mb-4">{{ __('messages.smart_automation') }}</a>
                                    <p class="mb-4">{{ __('messages.smart_automation_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('assets/img/smart2.jpg') }}" class="img-fluid rounded-top w-100" alt="">
                                <div class="service-icon p-3">
                                    <i class="fa fa-desktop fa-2x"></i>
                                </div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="d-inline-block h4 mb-4">{{ __('messages.smart_it_solutions') }}</a>
                                    <p class="mb-4">{{ __('messages.smart_it_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <!-- Service End -->

        <style>
            .service-item img {
            width: 100%;
            height: 250px; /* Anda bisa sesuaikan tinggi yang diinginkan */
            object-fit: cover; /* Untuk memastikan gambar tetap dalam rasio */
        }
        </style>

        </div>
        
        <!-- Our Products Start -->
        <style>
            .product-item {
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
                border-radius: 10px;
            }
        
            .product-item:hover {
                transform: translateY(-10px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }
        
            .product-img img {
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }
        
            .product-content {
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
                background-color: #fff;
            }
        
            .product-content-inner a {
                color: #333;
                font-weight: bold;
                transition: color 0.3s ease;
            }
        
            .product-content-inner a:hover {
                color: #007bff;
            }
        
            
        
            .btn-primary:hover {
                background-color: #0056b3;
            }
        
            .product-icon {
                background-color: rgba(255, 255, 255, 0.85);
                border-radius: 50%;
                position: absolute;
                top: -25px;
                left: 20px;
            }
        </style>
        
             <!-- Contact Start -->
        <div class="container-fluid contact bg-light py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ __('messages.contact') }}</h4>
                    <h1 class="display-4 mb-4">{{ __('messages.comments_apply') }}</h1>
                </div>
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="contact-img d-flex justify-content-center">
                            <div class="contact-img-inner">
                                <img src="{{ asset($compayny->logo ?? 'assets/img/logo.png') }}" class="img-fluid" alt="Image">
                            </div>
                        </div>
                    </div>

                    <style>
                        .contact-img {
                        position: relative;
                        height: 100%; /* Ensure the parent has a set height */
                    }

                    .contact-img-inner {
                        position: absolute;
                        top: 80%; /* Center vertically */
                        left: 50%; /* Center horizontally */
                        transform: translate(-50%, -50%); /* Adjust to center the element properly */
                        max-width: 100%; /* Optional: Limit the size of the logo to fit within the container */
                    }

                    /* Adjustments for mobile screens */
                    @media (max-width: 768px) {
                        .contact-img-inner {
                            top: 50%; /* More central vertical positioning on mobile */
                            max-width: 100%; /* Optionally adjust the max width for smaller screens */
                            
                        }
                    }
                    </style>

                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                        <div>
                            <h4 class="text-primary">{{ __('messages.send_message_title') }}</h4>
                            <p class="mb-4">{{ __('messages.send_message_description') }}</p>
                            
                            <form method="POST" action="{{ route('contact.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control border-0" id="name" placeholder="{{ __('messages.contact_form.your_name') }}" required>
                                            <label for="name">{{ __('messages.contact_form.your_name') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control border-0" id="email" placeholder="{{ __('messages.contact_form.your_email') }}" required>
                                            <label for="email">{{ __('messages.contact_form.your_email') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" name="phone" class="form-control border-0" id="phone" placeholder="{{ __('messages.contact_form.your_phone') }}"
                                                pattern="[0-9]{8,15}" title="Please enter a valid phone number (8-15 digits)" inputmode="numeric"
                                                minlength="8" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            <label for="phone">{{ __('messages.contact_form.your_phone') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" name="company" class="form-control border-0" id="project" placeholder="{{ __('messages.contact_form.your_company') }}">
                                            <label for="project">{{ __('messages.contact_form.your_company') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" name="subject" class="form-control border-0" id="subject" placeholder="{{ __('messages.contact_form.subject') }}" required>
                                            <label for="subject">{{ __('messages.contact_form.subject') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control border-0" name="message" placeholder="{{ __('messages.contact_form.message') }}" id="message" style="height: 120px" required></textarea>
                                            <label for="message">{{ __('messages.contact_form.message') }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3">{{ __('messages.contact_form.send_message') }}</button>
                                    </div>
                                </div>
                            </form>
                            
                            
                            
                        </div>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-3 bg-white p-3 rounded wow fadeInUp mx-2 mt-2" data-wow-delay="0.2s">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>{{ __('messages.contact_info.address') }}</h4>
                                        <p class="mb-0">{{ $company->address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-white p-3 rounded wow fadeInUp mx-2 mt-2" data-wow-delay="0.4s">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>{{ __('messages.contact_info.mail_us') }}</h4>
                                        <p class="mb-0">{{ $company->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 bg-white p-3 rounded wow fadeInUp mx-2 mt-2" data-wow-delay="0.6s">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fa fa-phone-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>{{ __('messages.contact_info.telephone') }}</h4>
                                        <p class="mb-0">{{ $company->no_wa }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-12 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="rounded">
                            <iframe class="rounded w-100" 
                            style="height: 400px;" src="{{ $company->maps_iframe }}" 
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

@endsection
