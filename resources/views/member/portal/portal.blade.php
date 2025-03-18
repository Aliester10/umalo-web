@extends('layouts.guest.master')

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 60px 0; transition: 0.5s;">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.member_portal') }}</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item">{{ __('messages.member_portal') }}</li>
            </ol>              
        </div>
    </div>
    <!-- Header End -->

    <!-- Services Start -->
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top" style="display: flex; justify-content: center; align-items: center; height: 200px; width: 200px; margin: 0 auto; background-color: #f8f9fa;">
                        <img src="{{ asset('assets/img/product.png')  }}" class="img-fluid" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">{{ __('messages.product') }}</h5>
                                <a href="{{ route('portal.user-product') }}"
                                    class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">{{ __('messages.more_details') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top"
                            style="display: flex; justify-content: center; align-items: center; height: 200px; width: 200px; margin: 0 auto; background-color: #f8f9fa;">
                            <img src="{{ asset('assets/img/manual.png')  }}" class="img-fluid" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">{{ __('messages.instructions') }}</h5>
                                <a href="{{ route('portal.instructions') }}"
                                    class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">{{ __('messages.more_details') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top"
                            style="display: flex; justify-content: center; align-items: center; height: 200px; width: 200px; margin: 0 auto; background-color: #f8f9fa;">
                            <img src="{{ asset('assets/img/documentation.png')  }}" class="img-fluid" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">{{ __('messages.documents') }}</h5>
                                <a href="{{ route('portal.document') }}"
                                    class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">{{ __('messages.more_details') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top"
                            style="display: flex; justify-content: center; align-items: center; height: 200px; width: 200px; margin: 0 auto; background-color: #f8f9fa;">
                            <img src="{{ asset('assets/img/cam-recorder.png')  }}" class="img-fluid" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">{{ __('messages.videos') }}</h5>
                                <a href="{{ route('portal.tutorials') }}"
                                    class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">{{ __('messages.more_details') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded">
                        <div class="service-img rounded-top"
                            style="display: flex; justify-content: center; align-items: center; height: 200px; width: 200px; margin: 0 auto; background-color: #f8f9fa;">
                            <img src="{{ asset('assets/img/inspection.png')  }}" class="img-fluid" alt="">
                        </div>
                        <div class="service-content rounded-bottom bg-light p-4">
                            <div class="service-content-inner">
                                <h5 class="mb-4">{{ __('messages.monitoring') }}</h5>
                                <a href="{{ route('portal.monitoring') }}"
                                    class="btn btn-primary rounded-pill text-white py-2 px-4 mb-2">{{ __('messages.more_details') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->
@endsection
