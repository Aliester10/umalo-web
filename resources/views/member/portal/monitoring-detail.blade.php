@extends('layouts.guest.master')

@section('content')
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background: linear-gradient(rgb(7, 51, 7), rgba(0, 0, 0, 0.2)), url('{{ asset('assets/img/default_about.jpg') }}'); position: relative; background-position: center; background-repeat: no-repeat; background-size: cover; padding: 60px 0;">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h1 class="text-white display-5 mb-4">{{ __('messages.detail_inspeksi_maintenance') }}</h1>
        <h4 class="text-white">{{ __('messages.monitoring') }}: {{ $userProduk->produk->nama }}</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portal') }}" class="text-white">{{ __('messages.member_portal') }}</a></li>
            <li class="breadcrumb-item text-white">{{ __('messages.detail_inspeksi_maintenance') }}</li>
        </ol>   
    </div>
</div>
<!-- Header End -->

<!-- Inspeksi Maintenance Details Start -->
<div class="container mt-5 mb-5">
    @if($userProduk->inspeksiMaintenance->count() > 0)
    <div class="row g-4">
        @foreach($userProduk->inspeksiMaintenance as $inspeksi)
        <div class="col-md-6">
            <div class="card h-100 shadow border-0 rounded-lg">
                <div class="card-body">
                    <h5 class="card-title">{{ $inspeksi->status }} - {{ $inspeksi->pic }}</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted">{{ __('messages.pic') }}</th>
                            <td>: {{ $inspeksi->pic }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('messages.waktu') }}</th>
                            <td>: {{ $inspeksi->waktu }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('messages.deskripsi') }}</th>
                            <td class="card shadow-sm bg-light"> {!! $inspeksi->deskripsi !!}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('messages.status') }}</th>
                            <td>: {{ $inspeksi->status }}</td>
                        </tr>
                    
                        <!-- Display gambar if available -->
                        @if($inspeksi->gambar)
                        <tr>
                            <th class="text-muted">{{ __('messages.file') }}</th>
                            <td>:
                                @php
                                    $fileExtension = pathinfo($inspeksi->gambar, PATHINFO_EXTENSION);
                                @endphp
                    
                                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                    <!-- Display image -->
                                    <img src="{{ asset( $inspeksi->gambar) }}" class="img-fluid rounded mb-3" alt="Inspeksi Image">
                                @elseif($fileExtension === 'pdf')
                                    <!-- Display PDF with a download/view link -->
                                    <a href="{{ asset( $inspeksi->gambar) }}" target="_blank" class="btn btn-outline-info">
                                        <i class="fas fa-file-pdf"></i> {{ __('messages.view_pdf') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td class="text-muted">{{ __('messages.no_file_available') }}</td>
                        </tr>
                        @endif
                    </table>
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-warning mt-5">
        Tidak ada data inspeksi maintenance untuk produk ini.
    </div>
    @endif

    <div class="text-center mt-5">
        <a class="btn btn-primary rounded-pill px-4 py-2 mb-5" href="javascript:history.back()">{{ __('messages.back') }}</a>
    </div>
</div>
<!-- Inspeksi Maintenance Details End -->
@endsection
