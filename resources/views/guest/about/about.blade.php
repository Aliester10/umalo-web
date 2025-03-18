@extends('layouts.guest.master')

@section('content')
           <!-- Header Start -->
           <div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/about_banner.jpg') }}'); position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 20px 0; transition: 0.5s;">
            <div class="container text-center py-3" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.about_us') }}</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item  text-white">{{ __('messages.about') }}</li>
                </ol>
            </div>
        </div>

        <!-- Header End -->

        <!-- About Start -->
        <div class="container-fluid bg-light about py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-xl-4 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-item-content bg-white rounded p-5 h-100">
                            <h4 class="text-primary">{{ $company->company_name ?? 'Umalo Sedia Tekno' }}</h4>
                            <h1 class="display-4 mb-4">{{ $company->slogan ?? 'Way To Know' }}</h1>
                            <p>{{ $company->short_history ?? 'PT. Umalo Sedia Tekno is an industry leader in providing innovative IT solutions and smart technology systems. Established in 2023, we specialize in integrating cutting-edge technologies to streamline operations, enhance security, and foster innovation across various industries. Our commitment to excellence and innovation has positioned us at the forefront of the smart technology revolution' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-8 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-white rounded p-5 h-100">
                            <div class="row g-4 justify-content-center">
                                <div class="col-12 image-container">
                                    <div class="rounded bg-light">
                                        <img src="{{ $company && $company->about_gambar ? asset('storage/' . $company->about_gambar) : asset('assets/img/default_about.jpg') }}" class="img-fluid rounded w-100" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="counter-item bg-light rounded p-3 h-100">
                                        <div class="counter-counting">
                                            <span class="text-primary fs-2 fw-bold">VISI</span>
                                        </div>
                                        <p class="mb-0 text-dark">{{ $company->visi ?? ' ' }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="counter-item bg-light rounded p-3 h-100">
                                        <div class="counter-counting">
                                            <span class="text-primary fs-2 fw-bold">MISI</span>
                                        </div>
                                        <p class="mb-0 text-dark">{{ $company->misi ?? ' ' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @media (max-width: 768px) {
                .image-container {
                    display: none; /* Hide the image container on mobile */
                }
            }
        </style>

        <!-- About End -->


       <!-- Feature Start -->
        <div class="container-fluid feature bg-light py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Umalo</h4>
                    <h1 class="display-4 mb-4">{{ __('messages.core_values_title') }}</h1>
                    <p class="mb-0">{{ __('messages.core_values_description') }}</p>
                </div>
                <!-- First row with 3 columns -->
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="feature-item p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="far fa-handshake fa-3x"></i>
                            </div>
                            <h4 class="mb-4">{{ __('messages.innovation') }}</h4>
                            <p class="mb-4">{{ __('messages.innovation_description') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="feature-item p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fa fa-dollar-sign fa-3x"></i>
                            </div>
                            <h4 class="mb-4">{{ __('messages.integrity') }}</h4>
                            <p class="mb-4">{{ __('messages.integrity_description') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="feature-item p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fa fa-bullseye fa-3x"></i>
                            </div>
                            <h4 class="mb-4">{{ __('messages.customer_focus') }}</h4>
                            <p class="mb-4">{{ __('messages.customer_focus_description') }}</p>
                        </div>
                    </div>
                </div>
                <!-- Second row with 2 columns -->
                <div class="row g-4 mt-2 justify-content-center">
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="feature-item p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fa fa-headphones fa-3x"></i>
                            </div>
                            <h4 class="mb-4">{{ __('messages.collaboration') }}</h4>
                            <p class="mb-4">{{ __('messages.collaboration_description') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="1s">
                        <div class="feature-item p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fa fa-shield-alt fa-3x"></i>
                            </div>
                            <h4 class="mb-4">{{ __('messages.excellence') }}</h4>
                            <p class="mb-4">{{ __('messages.excellence_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Feature End -->



@endsection
