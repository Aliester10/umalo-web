@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2>Tambah Produk untuk {{ $member->name }}</h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('members.store-products', $member->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body d-flex flex-column">
                                            <!-- Display the first product image if available -->
                                            @if($product->images->isNotEmpty())
                                                <div class="mb-3 text-center">
                                                    @php
                                                        $firstImage = $product->images->first();
                                                    @endphp
                                                    <img src="{{ asset($firstImage->images) }}" class="img-fluid mb-3" alt="{{ $product->name }}" style="max-height: 150px; object-fit: cover;">
                                                </div>
                                            @else
                                                <div class="mb-3 text-center">
                                                    <img src="{{ asset('assets/img/default.jpg') }}" class="img-fluid mb-3" alt="Default Image" style="max-height: 150px; object-fit: cover;">
                                                </div>
                                            @endif

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="product_id[{{ $product->id }}]" value="{{ $product->id }}" id="product_{{ $product->id }}">
                                                <label class="form-check-label text-wrap" for="product_{{ $product->id }}">
                                                    {{ $product->name }}
                                                </label>
                                            </div>

                                            <!-- Tanggal Pembelian -->
                                            <div class="form-group mb-2">
                                                <label for="purchase_date_{{ $product->id }}">Tanggal Pembelian</label>
                                                <input type="date" name="purchase_date[{{ $product->id }}]" id="purchase_date_{{ $product->id }}" class="form-control">
                                            </div>

                                            <!-- Quantity -->
                                            <div class="form-group mb-2">
                                                <label for="quantity_{{ $product->id }}">Jumlah</label>
                                                <input type="number" name="quantity[{{ $product->id }}]" id="quantity_{{ $product->id }}" class="form-control" min="1" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Tambah Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
