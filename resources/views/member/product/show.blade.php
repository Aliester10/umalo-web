@extends('layouts.member.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Detail Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Image Section --}}
                        <div class="col-md-4 text-center">
                            <img src="{{ asset($userProduct->product->images->first()->images ?? 'assets/img/default.jpg') }}" 
                                 alt="{{ $userProduct->product->name }}" 
                                 class="img-fluid rounded mb-3 shadow" style="height: 250px; object-fit: cover;">
                        </div>

                        {{-- Product Details Section --}}
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $userProduct->product->name }}</h3>
                            <p><strong>Tanggal Pembelian:</strong> {{ $userProduct->purchase_date ?? 'N/A' }}</p>
                            <p><strong>Jumlah:</strong> {{ $userProduct->quantity }}</p>
                            <p><strong>Deskripsi:</strong> {{ $userProduct->product->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>

                    {{-- Videos Section --}}
                    @if($userProduct->product->videos->isNotEmpty())
                        <div class="mt-4">
                            <h5 class="mb-3">Videos</h5>
                            <div class="row g-3">
                                @foreach($userProduct->product->videos as $video)
                                    <div class="col-md-6">
                                        <div class="card shadow">
                                            <video controls style="width: 100%; height: auto;">
                                                <source src="{{ asset($video->video) }}" type="video/mp4">
                                                Browser Anda tidak mendukung video.
                                            </video>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Brosur Section --}}
                    @if($userProduct->product->brosur->isNotEmpty())
                        <div class="mt-4">
                            <h5 class="mb-3">Brosur</h5>
                            <div class="row g-3">
                                @foreach($userProduct->product->brosur as $brosur)
                                    <div class="col-md-6">
                                        <div class="card shadow text-center">
                                            @php
                                                $extension = pathinfo($brosur->file, PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array($extension, ['jpeg', 'jpg', 'png', 'gif']))
                                                <a href="{{ asset($brosur->file) }}" target="_blank">
                                                    <img src="{{ asset($brosur->file) }}" alt="Brosur" class="img-fluid rounded" style="height: 200px; object-fit: cover;">
                                                </a>
                                            @elseif($extension === 'pdf')
                                                <a href="{{ asset($brosur->file) }}" target="_blank" class="btn btn-primary btn-sm mt-3">
                                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                                </a>
                                            @else
                                                <a href="{{ asset($brosur->file) }}" target="_blank" class="btn btn-secondary btn-sm mt-3">
                                                    <i class="fas fa-download"></i> Unduh File
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- User Manual Section --}}
                    @if($userProduct->product->userManual->isNotEmpty())
                        <div class="mt-4">
                            <h5 class="mb-3">User Manual</h5>
                            <div class="row g-3">
                                @foreach($userProduct->product->userManual as $manual)
                                    <div class="col-md-6">
                                        <div class="card shadow text-center">
                                            @php
                                                $extension = pathinfo($manual->file, PATHINFO_EXTENSION);
                                            @endphp
                                            @if($extension === 'pdf')
                                                <a href="{{ asset($manual->file) }}" target="_blank" class="btn btn-primary btn-sm mt-3">
                                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                                </a>
                                            @else
                                                <a href="{{ asset($manual->file) }}" target="_blank" class="btn btn-secondary btn-sm mt-3">
                                                    <i class="fas fa-download"></i> Unduh User Manual
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('member.products.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
