<body>

    @php
    $activeMetas = \App\Models\Meta::where('start_date', '<=', today())
        ->where('end_date', '>=', today())
        ->get()
        ->groupBy('type');

    $compro = \App\Models\CompanyParameter::first();
    @endphp

        <!-- Topbar Start -->
        <div class="container-fluid topbar px-0 px-lg-4 bg-light py-2 d-none d-lg-block">
            <div class="container">
                <div class="row gx-0 align-items-center">
                    <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                        <div class="d-flex flex-wrap">
                            <div class="border-end border-primary pe-3">
                                @if(!empty($compro->maps_url))
                                    <a href="{{ $compro->maps_url }}" class="text-muted small">
                                @endif
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>{{ __('messages.find_location') }}
                                </a> 
                            </div>
                            @if (!empty($compro->email))
                                <div class="ps-3">
                                    <a href="mailto:{{ $compro->email }}" class="text-muted small">
                                        <i class="fas fa-envelope text-primary me-2"></i>{{ $compro->email }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end">
                        <div class="d-flex justify-content-end">
                            <div class="d-flex border-end border-primary pe-3">
                                {!! !empty($compro->linkedin) ? 
                                    '<a class="btn p-0 text-primary me-0" href="' . $compro->linkedin . '" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                     </a>' 
                                    : '' !!}
                            </div>
                            <div class="dropdown ms-3">
                                <a href="#" class="dropdown-toggle text-dark" data-bs-toggle="dropdown"><small><i class="fas fa-globe-europe text-primary me-2"></i>
                                    @if(LaravelLocalization::getCurrentLocale() == 'id')
                                    Bahasa</small></a>
                                    @elseif(LaravelLocalization::getCurrentLocale() == 'en')
                                    English</small></a>
                                    @else
                                        {{ LaravelLocalization::getCurrentLocaleNative() }}
                                    @endif   
                                <div class="dropdown-menu rounded">
                                    <a href="{{ LaravelLocalization::getLocalizedURL('id') }}" class="dropdown-item">
                                        {{ __('messages.bahasa') }} 
                                    </a>
                                    <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="dropdown-item">
                                        {{ __('messages.english') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->



        <!-- Navbar & Hero Start -->
        <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light"> 
                    <a href="{{ route('home') }}" class="navbar-brand p-0">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-img">
                        <img src="{{ asset('assets/img/ekatalog.png') }}" alt="Logo" class="logo-img">
                        <img src="{{ asset('assets/img/lokal.png') }}" alt="Logo" class="logo-img">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav mx-0 mx-lg-auto">
                            <a href="{{ route('home') }}" class="nav-item nav-link {{ Route::is('home') ? 'active' : '' }}">{{ __('messages.home') }}</a>
                            <a href="{{ route('about') }}" class="nav-item nav-link {{ Route::is('about') ? 'active' : '' }}">{{ __('messages.about') }}</a>
                            <a href="{{ route('activity') }}" class="nav-item nav-link {{ Route::is('activity') ? 'active' : '' }}">{{ __('messages.activities') }}</a>
                            <a href="{{ route('product.index') }}" class="nav-item nav-link {{ Route::is('product.index') ? 'active' : '' }}">{{ __('messages.products') }}</a>
                            <a href="{{ route('contact') }}" class="nav-item nav-link" {{ Route::is('contact') ? 'active' : '' }}>{{ __('messages.contactUS') }}</a>                            
                            <a href="{{ route('faq') }}" class="nav-item nav-link" {{ Route::is('faq') ? 'active' : '' }}>{{ __('messages.faqs') }}</a>                            
                            @auth
                            <a href="{{ route('portal') }}" class="nav-item nav-link btn btn-primary py-2 px-4 ms-3 text-white"   {{ Route::is('portal') ? 'active' : '' }}">Portal</a>
                        @endauth
                        

                        @foreach ($activeMetas as $type => $metas)
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle {{ Request::is('member/meta/*') ? 'active' : '' }}" id="navbarDropdown-{{ $type }}" aria-expanded="false" data-bs-toggle="dropdown">{{ ucfirst($type) }}</a>
                                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown-{{ $type }}">
                                        @foreach ($metas as $meta)
                                            <a href="{{ route('member.meta.show', $meta->slug) }}" class="dropdown-item {{ Route::is('member.meta.show') && request()->slug == $meta->slug ? 'active' : '' }}">{{ $meta->title }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <!-- Bahasa Selector (Mode Mobile) -->
                            <div class="nav-item nav-link dropdown d-block d-lg-none">
                                <a href="#" class="dropdown-toggle text-dark" data-bs-toggle="dropdown">
                                    <small><i class="fas fa-globe-europe text-primary me-2"></i>
                                    @if(LaravelLocalization::getCurrentLocale() == 'id')
                                        Bahasa
                                    @elseif(LaravelLocalization::getCurrentLocale() == 'en')
                                        English
                                    @else
                                        {{ LaravelLocalization::getCurrentLocaleNative() }}
                                    @endif
                                    </small>
                                </a>
                                <div class="dropdown-menu m-0">
                                    <a href="{{ LaravelLocalization::getLocalizedURL('id') }}" class="dropdown-item">
                                        {{ __('messages.bahasa') }}
                                    </a>
                                    <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="dropdown-item">
                                        {{ __('messages.english') }}
                                    </a>
                                </div>
                            </div>

                            <div class="nav-btn nav-link">
                                @guest
                                    <!-- If the user is not logged in, show the "Member" button -->
                                    <a href="{{ route('login') }}" class="nav-item nav-link text-white btn btn-primary py-2 px-4 ms-3 flex-shrink-0">Masuk</a>
                                @endguest
                            
                                @auth
                                    <!-- If the user is logged in, show the company name or 'Your Company' with a dropdown -->
                                    <div class="nav-item dropdown d-md-none">
                                        <a href="#" class="nav-link dropdown-toggle text-white btn btn-primary rounded-pill p-2 flex-shrink-0" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ Auth::user()->nama_perusahaan ?? 'Your Company' }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>
                                            </li>
                                        </ul>
                                    
                                        <!-- Logout form -->
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                    
                                @endauth
                            </div>
                            
                        </div>
                    </div>
                    @auth
                    <!-- Tampilkan dropdown user hanya pada layar besar, sembunyikan di mobile -->
                    <div class="dropdown ps-2 d-none d-lg-flex align-items-center">
                        <!-- Ikon User dalam lingkaran -->
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>

                        <!-- Nama Perusahaan sebagai pemicu dropdown -->
                        <a href="#" class="dropdown-toggle ms-3 rounded bg-light p-2" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>{{ Str::limit(Auth::user()->nama_perusahaan, 15, '...') ?? 'Your Company' }}</span>
                        </a>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Tampilkan WhatsApp hanya di layar besar, sembunyikan di mobile -->
                    @if (!empty($compro->no_wa))
                    <div class="d-none d-lg-flex flex-shrink-0 ps-4">
                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $compro->no_wa) }}?text={{ urlencode(__('messages.consult_text')) }}" 
                        class="btn btn-light btn-lg-square rounded-circle position-relative wow tada" 
                        data-wow-delay=".9s" target="_blank">
                            <i class="fab fa-whatsapp fa-2x text-success"></i>
                            <div class="position-absolute" style="top: 7px; right: 12px;">
                                <span><i class="fa fa-comment-dots text-secondary"></i></span>
                            </div>
                        </a>

                        <!-- WhatsApp Details -->
                        <div class="d-flex flex-column ms-3">
                            <span>{{ __('messages.consult_with_experts') }}</span>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $compro->no_wa) }}?text={{ urlencode(__('messages.consult_text')) }}" target="_blank" class="text-decoration-none">
                                <span class="text-dark">{{ __('messages.whatsapp_contact', ['no_wa' => $compro->no_wa]) }}</span>
                            </a>
                        </div>
                    </div>
                @endif

                @endauth

                </nav>
                    <style>
                        .logo-img {
                        max-height: 60px; /* Menyesuaikan tinggi logo */
                        width: auto; /* Agar proporsional */
                        margin-left: 10px; /* Menambah ruang di kiri logo */
                        margin-right: 10px; /* Menambah ruang di kanan logo */
                    }

                    @media (max-width: 992px) {
                        .logo-img {
                            max-height: 50px; /* Menyesuaikan tinggi logo untuk layar yang lebih kecil */
                        }
                    }
                    

                    </style>    
                    
                    
            </div>
        </div>
        <!-- Navbar & Hero End -->