@extends('layouts.guest.master')

@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <h3 class="text-center mb-5">Your Product Photos</h3>

        <div class="row">
            @forelse($produks as $produk)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($produk->images->first()->gambar ?? 'assets/img/default.jpg') }}" alt="Product Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $produk->nama }}</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $produk->id }}">
                                More
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="productModal{{ $produk->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $produk->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel{{ $produk->id }}">{{ $produk->nama }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="carouselExampleIndicators{{ $produk->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach($produk->images as $key => $image)
                                            <button type="button" data-bs-target="#carouselExampleIndicators{{ $produk->id }}" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}"></button>
                                        @endforeach
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach($produk->images as $key => $image)
                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->gambar ?? 'assets/img/default.jpg') }}" class="d-block w-100" alt="Product Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators{{ $produk->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black; filter: invert(1);"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators{{ $produk->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon text-dark" aria-hidden="true" style="background-color: black; filter: invert(5);"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">You don't have any products with images.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
