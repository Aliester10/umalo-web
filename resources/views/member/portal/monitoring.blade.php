@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}');     position: relative; overflow: hidden; background-position: center center; background-repeat: no-repeat; background-size: cover; padding: 60px 0; transition: 0.5s;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">{{ __('messages.monitoring') }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal') }}">{{ __('messages.member_portal') }}</a></li>
            <li class="breadcrumb-item">{{ __('messages.monitoring') }}</li>
        </ol>  
    </div>
</div>
<!-- Header End -->

<!-- Services Start -->
<div class="container mt-5 mb-5">
    @if($userProduks->isEmpty())
    <div class="alert alert-warning text-center">
        {{ __('messages.no_products_to_monitor') }}
    </div>
    @else
        <div class="row">
            @foreach($userProduks as $userProduk)
            <div class="col-md-4 mb-4">
                <div class="card rounded-top shadow-sm">
                    <img src="{{ asset($userProduk->produk->images->first()->gambar ?? 'assets/img/default.jpg') }}" class="card-img-top img-fluid" alt="{{ $userProduk->produk->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $userProduk->produk->nama }}</h5>
                        <p class="card-text">{{ Str::limit($userProduk->produk->deskripsi, 100) }}</p>
                        
                        <!-- Display Monitoring Info -->
                        @if($userProduk->monitoring)
                        <h6>{{ __('messages.monitoring') }}</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>{{ __('messages.status_barang') }}</th>
                                    <td class="bg-info text-white">{{ $userProduk->monitoring->status_barang }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('messages.kondisi_terakhir') }}</th>
                                    <td class="bg-warning text-white">{{ $userProduk->monitoring->kondisi_terakhir_produk }}</td>
                                </tr>
                            </table>
                            
                        @else
                            <p>{{ __('messages.no_monitoring_data') }}</p>
                        @endif
                        <a href="{{ route('portal.monitoring.detail', $userProduk->id) }}" class="btn btn-primary mt-2">{{ __('messages.product_details') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    <div style="text-align: center;">
        <a class="btn btn-primary rounded-pill mt-5 mb-5 wow fadeInDown" data-wow-delay="0.5s" href="javascript:history.back()">{{ __('messages.back') }}</a>
    </div>
</div>
<!-- Services End -->
@endsection
