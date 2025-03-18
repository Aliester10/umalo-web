@php
use Carbon\Carbon; // Pastikan Carbon tersedia
use \App\Models\CompanyParameter;

$company = CompanyParameter::first();
$thisYear = Carbon::now()->format('Y');

@endphp
        
        <!-- Footer Start -->
        <div class="container-fluid footer wow fadeIn" data-wow-delay="0.2s">
            <div class="container ">
                <div class="row g-5">
                    <div class="col-xl-9">
                        <div class="mb-5">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-6 col-xl-5">
                                    <div class="footer-item">
                                        <a href="{{ route('about') }}" class="p-0 mb-2 text-start mb-4">
                                            @if(isset($company) && $company->logo)
                                                <img src="{{ asset($company->logo) }}" 
                                                     alt="Logo" 
                                                     class="logo-img" 
                                                     style="filter: brightness(0) invert(1); max-height: 60px; width: auto;">
                                            @else
                                                <img src="{{ asset('assets/img/logo.png') }}" 
                                                     alt="Default Logo" 
                                                     class="logo-img" 
                                                     style="filter: brightness(0) invert(1); max-height: 60px; width: auto;">
                                            @endif
                                    
                                            @if(isset($company) && $company->logo_support_2)
                                                <img src="{{ asset($company->logo_support_2) }}" 
                                                     alt="Support Logo 2" 
                                                     class="logo-img" 
                                                     style="filter: brightness(0) invert(1); max-height: 30px; width: auto;">
                                            @endif
                                    
                                            @if(isset($company) && $company->logo_support_3)
                                                <img src="{{ asset($company->logo_support_3) }}" 
                                                     alt="Support Logo 3" 
                                                     class="logo-img" 
                                                     style="filter: brightness(0) invert(1); max-height: 30px; width: auto;">
                                            @endif
                                        </a>
                                    
                                        <p class="text-white mb-4 text-start">
                                            {{ __('messages.footer_about') }}
                                        </p>
                                    
                                        <div class="footer-btn d-flex">
                                            @if(isset($company) && !empty($company->linkedin))
                                                <a class="btn btn-md-square rounded-circle me-0" href="{{ $company->linkedin }}" target="_blank">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="footer-item">
                                        <h4 class="text-white mb-4">{{ __('messages.useful_links') }}</h4>
                                        <a href="{{ route('home') }}"><i class="fas fa-angle-right me-2"></i> {{ __('messages.home') }}</a>
                                        <a href="{{ route('about') }}"><i class="fas fa-angle-right me-2"></i> {{ __('messages.about') }}</a>
                                        <a href="{{ route('activity') }}"><i class="fas fa-angle-right me-2"></i> {{ __('messages.activities') }}</a>
                                        <a href="{{ route('product.index') }}"><i class="fas fa-angle-right me-2"></i> {{ __('messages.products') }}</a>        
                                        <a href="{{ route('faq') }}"><i class="fas fa-angle-right me-2"></i> {{ __('messages.faqs') }}</a>  
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-4">
                                    <div class="footer-item">
                                        <h4 class="mb-4 text-white">{{ __('messages.more') }}</h4>
                                        <div class="row g-3">
                                            <!-- Address Section -->
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <div class="btn-xl-square bg-white text-success rounded p-3 me-3">
                                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-white">{{ __('messages.address') }}</h5>
                                                        @if (!empty($company->address))
                                                            <p class="mb-0">
                                                                <small>{{ \Illuminate\Support\Str::limit($company->address, 22, '...') }}</small>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Mail Section -->
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-start">
                                                    <div class="btn-xl-square bg-white text-success rounded p-3 me-3">
                                                        <i class="fas fa-envelope fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-white">{{ __('messages.email_us') }}</h5>
                                                            @if (!empty($company->email))
                                                            <p class="mb-0"><small>{{ $company->email }}</small></p>
                                                        @endif                                                    
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Telephone Section -->
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-start">
                                                    <div class="btn-xl-square bg-white text-success rounded p-3 me-3">
                                                        <i class="fab fa-whatsapp fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-white">{{ __('messages.whatsapp') }}</h5>
                                                        @if (!empty($company->no_wa))
                                                            <p class="mb-0"><small>{{ $company->no_wa }}</small></p>
                                                        @endif                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">{{ __('messages.our_location') }}</h4>
                            <p class="text-white mb-3">{{ __('messages.location_description') }}</p>        
                            <div class="position-relative rounded-pill mb-4">
                                <!-- Menambahkan iframe Google Maps -->
                                @if (!empty($company->maps_iframe))
                                    <iframe 
                                        src="{{ $company->maps_iframe }}" 
                                        width="100%" 
                                        height="200" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy">
                                    </iframe>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-md-0">
                        <span class="text-body">
                            <a href="#" class=" text-white">
                                <i class="fas fa-copyright text-light me-2"></i>Umalo IT Division
                                <a>, 2024 - {{ $thisYear }} 
                                    @if (!empty($company->company_name))
                                        {{ $company->company_name }}
                                    @endif
                                    . Made with <i class="fa fa-heart heart text-danger"></i>
                                </a>
                        </span>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/lib/member/wow/wow.min.js') }}"></script>
<script src="{{ asset('assets/lib/member/easing/easing.min.js') }}"></script>
<script src="{{ asset('assets/lib/member/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/lib/member/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/member/main.js') }}"></script>
<script src="{{ asset('assets/lib/member/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('assets/lib/member/lightbox/js/lightbox.min.js') }}"></script>
</body>

</html>
