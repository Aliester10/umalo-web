@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2>Edit Produk untuk {{ $member->name }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('members.update-products', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            @foreach($member->usersProduct as $userProduk)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body d-flex flex-column">
                                            @if($userProduk->product->images->isNotEmpty())
                                                <div class="mb-3 text-center">
                                                    <img src="{{ asset($userProduk->product->images->first()->images ?? 'assets/img/default.jpg') }}" 
                                                        class="img-fluid mb-3" 
                                                        alt="{{ $userProduk->product->name }}" 
                                                        style="max-height: 150px; object-fit: cover;">
                                                </div>
                                            @else
                                                <div class="mb-3 text-center">
                                                    <img src="{{ asset('assets/img/default.jpg') }}" 
                                                        class="img-fluid mb-3" 
                                                        alt="Default Image" 
                                                        style="max-height: 150px; object-fit: cover;">
                                                </div>
                                            @endif

                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="product_id[]" value="{{ $userProduk->product->id }}" id="product_{{ $userProduk->product->id }}" checked>
                                                <label class="form-check-label text-wrap" for="product_{{ $userProduk->product->id }}">
                                                    {{ $userProduk->product->name }}
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label for="purchase_date_{{ $userProduk->product->id }}">Tanggal Pembelian</label>
                                                <input type="date" name="purchase_date[{{ $userProduk->product->id }}]" id="purchase_date_{{ $userProduk->product->id }}" class="form-control" value="{{ $userProduk->purchase_date }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="quantity_{{ $userProduk->product->id }}">Jumlah</label>
                                                <input type="number" name="quantity[{{ $userProduk->product->id }}]" id="quantity_{{ $userProduk->product->id }}" class="form-control" value="{{ $userProduk->quantity }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Perbarui Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
