@extends('layouts.guest.master')

@section('content')
<div class="container py-5 mt-2 mb-5">
    <div class="row rounded p-5">
        <!-- Bagian Kiri: Galeri images -->
        <div class="col-lg-7">
            <div class="row g-2">
                @if($product->images->count() > 1)
                    <!-- Carousel only for mobile devices -->
                    <div id="productImageCarousel" class="carousel slide d-block d-md-none" data-bs-ride="carousel">
                        <div class="carousel-inner mb-3">
                            @foreach ($product->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->images ?? 'https://via.placeholder.com/300x200?text=Product+Image') }}" 
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
                                                <img src="{{ asset($image->images ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" class="img-fluid w-100" alt="Product Image" style="object-fit: contain;">
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
                        @foreach ($product->images as $key => $image)
                            <div class="col-6 p-3">
                                <div class="product-image-item">
                                    <img src="{{ asset($image->images ?? 'https://via.placeholder.com/300x200?text=Product+Image') }}" 
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
                                            <img src="{{ asset($image->images ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" class="img-fluid w-100" alt="Product Image" style="object-fit: contain;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
        
                @else
                    <!-- Jika hanya ada 1 images, tampilkan images besar -->
                    <div class="col-12">
                        <div class="product-image-item">
                            <img src="{{ asset($product->images->first()->images ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" 
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
                                        <img src="{{ asset($product->images->first()->images ?? 'https://via.placeholder.com/700x500?text=Product+Image') }}" class="img-fluid w-100" alt="Product Image" style="object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        

        <!-- Bagian Kanan: Informasi product -->
        <div class="col-lg-5">
            <div class="product-info">
                <h1 class="product-title display-6 fw-bold">{{ $product->name }}</h1>
                <hr>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>{{ __('messages.brand') }}</th>
                            <td>{{ $product->brand }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.usage') }}</th>
                            <td>{{ $product->usage }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.category') }}</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        @if ($product->ekatalog)
                        <tr>
                            <th>{{ __('Ekatalog') }}</th>
                            <td>
                                <a href="{{ (strpos($product->ekatalog, 'http://') === 0 || strpos($product->ekatalog, 'https://') === 0) ? $product->ekatalog : 'http://' . $product->ekatalog }}" target="_blank">
                                    Ekatalog
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if($product->brosur->isNotEmpty())
                        <tr>
                            <th>{{ __('messages.brochure') }}</th>
                            <td>
                                @php
                                    $brosur = $product->brosur->first();
                                    $fileExtension = pathinfo($brosur->file, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <a href="{{ asset($brosur->file) }}" class="btn btn-outline-primary btn-sm" target="_blank">{{ __('messages.view') }}</a>
                                @elseif($fileExtension == 'pdf')
                                    <a href="{{ asset($brosur->file) }}" target="_blank" class="btn btn-outline-primary btn-sm">{{ __('messages.download_brochure_pdf') }}</a>
                                @else
                                    <p>{{ __('messages.unknown_file') }}</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Hubungi</th>
                            <td>
                                <a href="https://wa.me/6285282651911?text={{ urlencode('Halo, saya ingin menanyakan product ' . $product->name) }}" class="btn btn-outline-success btn-sm" target="_blank">
                                    <i class="fab fa-whatsapp"></i> Hubungi Admin
                                </a>
                            </td>
                        </tr>
                        
                        @endif
                    </tbody>
                </table>
            </div>
            
    <div class="col-12 text-center wow fadeInUp mt-5" data-wow-delay="0.2s">
        <a class="btn btn-primary rounded-pill" href="{{ route('product.index') }}">{{ __('messages.more_product') }}</a>
    </div>
</div>

    </div>
</div>

<!-- Product Lainnya -->
<!-- Product Lainnya -->
<div class="container py-5 mb-5">
    <h3 class="text-center mb-4">Other Products</h3>
    <div class="row g-4">
        @foreach($productLainnya as $product)
        <div class="col-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                <div class="product-item shadow-sm border rounded overflow-hidden position-relative" style="height: 100%; display: flex; flex-direction: column;">
                    <div class="product-img position-relative" style="height: 200px; overflow: hidden;">
                        <img src="{{ asset($product->images->first()->images ?? 'https://via.placeholder.com/300x200?text=Product+Image') }}" 
                            class="img-fluid w-100 h-100" 
                            style="object-fit: cover;" 
                            alt="{{ $product->name }}">
                        <!-- Verified Badge -->
                        <span class="product-verified">
                            <i class="fas fa-check-circle"></i> Umalo
                        </span>
                    </div>
                    <div class="product-content p-3 d-flex flex-column justify-content-between" style="flex-grow: 1;">
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
    </div>
</div>





<style>
.product-item {
    position: relative;
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
    border-radius: 8px; /* Sesuaikan dengan panutan */
    overflow: hidden; /* Pastikan konten tetap rapi */
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.product-img img {
    transition: transform 0.3s ease-in-out;
    border-radius: 8px 8px 0 0; /* Sesuaikan radius gambar */
    height: 100%;
    width: 100%;
    object-fit: cover; /* Pastikan gambar proporsional */
}

.product-item:hover .product-img img {
    transform: scale(1.05);
}

.product-title {
    line-height: 1.4;
    word-wrap: break-word;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-align: center; /* Pusatkan teks */
}

.product-content {
    padding: 1rem;
    text-align: center; /* Pusatkan teks */
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
@endsection
