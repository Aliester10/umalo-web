@extends('layouts.guest.master')

@section('content')

    <div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/product_perusahaan_it.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 20px 0; transition: 0.5s;">
        <div class="container text-center py-3" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.our_products') }}</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item active text-white text-dark">{{ __('messages.products') }}</li>
            </ol>
        </div>
    </div>



    <div class="container mt-5 mb-5 p-5">
        <div class="row">
            <div class="col-lg-3">
                <h4 class="mb-4 text-dark font-weight-bold">{{ __('messages.category') }}</h4>
                <ul class="list-group mb-4 shadow-sm">
                    <li class="list-group-item border-0 rounded text-center py-3 mb-2 shadow-sm"
                        style="cursor: pointer; background-color: {{ !$selectedCategory ? '#107C10' : '#f8f9fa' }}; transition: background-color 0.3s ease, color 0.3s ease;"
                        onmouseover="this.style.backgroundColor='#107C10'; this.style.color='#fff';"
                        onmouseout="this.style.backgroundColor='{{ !$selectedCategory ? '#107C10' : '#f8f9fa' }}'; this.style.color='{{ !$selectedCategory ? '#fff' : '#000' }}';"
                        onclick="window.location.href='{{ route('product.index') }}'">
                        <strong>{{ __('messages.all') }}</strong>
                    </li>

                    @foreach($category as $kat)
                        @if(!empty($kat->slug))
                            <li class="list-group-item border-0 rounded text-center py-3 mb-2 shadow-sm"
                                style="cursor: pointer; background-color: {{ $selectedCategory && $selectedCategory->slug == $kat->slug ? '#107C10' : '#f8f9fa' }}; transition: background-color 0.3s ease, color 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#107C10'; this.style.color='#fff';"
                                onmouseout="this.style.backgroundColor='{{ $selectedCategory && $selectedCategory->slug == $kat->slug ? '#107C10' : '#f8f9fa' }}'; this.style.color='{{ $selectedCategory && $selectedCategory->slug == $kat->slug ? '#fff' : '#000' }}';"
                                onclick="window.location.href='{{ route('filterByCategory', $kat->slug) }}'">
                                <strong>{{ $kat->name }}</strong>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>


            <div class="col-lg-9">
                <div class="d-flex justify-content-between mb-4">
                    <p class="font-weight-bold text-primary"><small>{{ __('messages.products_found', ['total' => $totalProduct]) }}</small></p>
                    <select class="form-select w-25 border-0 bg-light shadow-sm" id="sortSelect">
                        <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>{{ __('messages.newest') }}</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('messages.oldest') }}</option>
                    </select>
                </div>

                <script>
                    document.getElementById('sortSelect').addEventListener('change', function () {
                        var sort = this.value;
                        var url = new URL(window.location.href);
                        url.searchParams.set('sort', sort); // Tambahkan parameter sort ke URL
                        window.location.href = url.toString(); // Arahkan ke URL yang baru
                    });

                    window.addEventListener('load', function () {
                        var url = new URL(window.location.href);
                        if (!url.searchParams.get('sort')) {
                            url.searchParams.set('sort', 'newest');
                            window.location.href = url.toString();
                        }
                    });
                </script>


<div class="row">
    @foreach($products as $product)
    <div class="col-6 col-md-6 col-lg-4 col-xl-3 mb-4">
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
        </div>
    </div>
@endsection

<!-- Additional Custom CSS -->
<style>
.product-item {
    position: relative;
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
    border-radius: 8px; /* Tambahkan border radius untuk tampilan lebih modern */
    overflow: hidden; /* Pastikan konten tetap rapi */
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.product-img img {
    transition: transform 0.3s ease-in-out;
    border-radius: 8px 8px 0 0; /* Ikuti radius kartu */
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
}

.product-content {
    padding: 1rem;
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
