@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 60px 0; transition: 0.5s;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.product_detail') }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal') }}">{{ __('messages.member_portal') }}</a></li>
            <li class="breadcrumb-item">{{ __('messages.product_detail') }}</li>
        </ol>        
    </div>
</div>
<!-- Header End -->

<!-- Product Details Start -->
<div class="container py-5 mt-2 mb-5">
    <div class="row rounded shadow p-5">
        <!-- Bagian Kiri: Galeri Gambar -->
        <div class="col-lg-7">
            <div class="row g-2">
                @if($produk->images->count() > 1)
                    <!-- Carousel only for mobile devices -->
                    <div id="productImageCarousel" class="carousel slide d-block d-md-none" data-bs-ride="carousel">
                        <div class="carousel-inner mb-3">
                            @foreach ($produk->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->gambar ?? 'https://via.placeholder.com/300x200?text=Product+Image') }}" 
                                        class="d-block w-100" 
                                        alt="Product Image" 
                                        style="object-fit: cover; border-radius: 10px; height: 250px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#carouselImageModal-{{ $key }}">
                                </div>
        
                                <!-- Modal for carousel image view (Mobile) -->
                                <div class="modal fade" id="carouselImageModal-{{ $key }}" tabindex="-1" aria-labelledby="carouselImageModalLabel-{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{ asset($image->gambar ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" class="img-fluid w-100" alt="Product Image" style="object-fit: contain;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Controls for the slider -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" style="background-color: black" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" style="background-color: black" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
        
                    <!-- Grid layout for larger screens (Desktop) -->
                    <div class="row g-1 d-none d-md-flex">
                        @foreach ($produk->images as $key => $image)
                            <div class="col-6 p-3">
                                <div class="product-image-item">
                                    <img src="{{ asset($image->gambar ?? 'https://via.placeholder.com/300x200?text=Product+Image') }}" 
                                        class="d-block w-100" 
                                        alt="Product Image" 
                                        style="object-fit: cover; border-radius: 10px; height: 250px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#gridImageModal-{{ $key }}"
                                        onclick="event.stopPropagation();">
                                </div>
                            </div>
        
                            <!-- Modal for grid image view (Desktop) -->
                            <div class="modal fade" id="gridImageModal-{{ $key }}" tabindex="-1" aria-labelledby="gridImageModalLabel-{{ $key }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img src="{{ asset($image->gambar ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" class="img-fluid w-100" alt="Product Image" style="object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
        
                @else
                    <!-- Jika hanya ada 1 gambar, tampilkan gambar besar -->
                    <div class="col-12">
                        <div class="product-image-item">
                            <img src="{{ asset($produk->images->first()->gambar ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" 
                                 class="img-fluid w-100 product-image" 
                                 alt="Product Image" 
                                 style="object-fit: contain; border-radius: 10px; height: 500px;" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#singleImageModal">
                        </div>
        
                        <!-- Modal for single image view -->
                        <div class="modal fade" id="singleImageModal" tabindex="-1" aria-labelledby="singleImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="{{ asset($produk->images->first()->gambar ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" class="img-fluid w-100" alt="Product Image" style="object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        

        <!-- Bagian Kanan: Informasi Produk -->
        <div class="col-lg-5">
            <div class="product-info">
                <h1 class="product-title display-6 fw-bold">{{ $produk->nama }}</h1>
                <hr>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>{{ __('messages.brand') }}</th>
                            <td>{{ $produk->merk }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.usage') }}</th>
                            <td>{{ $produk->kegunaan }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.product_category') }}</th>
                            <td>{{ $produk->kategori->nama }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
    <div class="col-12 text-center wow fadeInUp mt-5" data-wow-delay="0.2s">
        <a class="btn btn-primary rounded-pill" href="javascript:history.back()">{{ __('messages.back') }}</a>
    </div>
</div>
    </div>
</div>

<!-- Product Details End -->

@endsection
