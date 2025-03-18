@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Detail Produk : {{ $produk->nama }}</h2>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Informasi Produk</h5>
                    <p><strong>Nama :</strong> {{ $produk->nama }}</p>
                    <p><strong>Merk :</strong> {{ $produk->merk }}</p>
                    <p><strong>Kegunaan :</strong> {{ $produk->kegunaan }}</p>
                    <p><strong>Via :</strong> {{ ucfirst($produk->via) }}</p>
                    <p><strong>Kategori :</strong> {{ $produk->kategori->nama }}</p>
                </div>
            </div>

            <!-- Gambar Produk -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Gambar Produk</h5>
                    @if($produk->images->count())
                        <div class="row">
                            @foreach($produk->images as $image)
                                <div class="col-md-3">
                                    <img src="{{ asset($image->gambar) }}" class="img-fluid img-thumbnail" alt="Gambar Produk">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tidak ada gambar untuk produk ini.</p>
                    @endif
                </div>
            </div>

            <!-- Video Produk -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Video Produk</h5>
                    @if($produk->videos->count())
                        <div class="row">
                            @foreach($produk->videos as $video)
                                <div class="col-md-3">
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset($video->video) }}" type="video/mp4">
                                            Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tidak ada video untuk produk ini.</p>
                    @endif
                </div>
            </div>

            <!-- Document Certification Produk -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Sertifikasi Dokumen</h5>
                    @if($produk->documentCertificationsProduk->count())
                        <ul>
                            @foreach($produk->documentCertificationsProduk as $doc)
                                <li>
                                    <a href="{{ asset($doc->pdf) }}" target="_blank">Lihat PDF Sertifikasi Dokumen</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada sertifikasi dokumen untuk produk ini.</p>
                    @endif
                </div>
            </div>

            <!-- Brosur Produk -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Brosur</h5>
                    @if($produk->brosur->count())
                        <ul>
                            @foreach($produk->brosur as $brosur)
                                <li>
                                    @if($brosur->type == 'pdf')
                                        <a href="{{ asset($brosur->file) }}" target="_blank">Lihat PDF Brosur</a>
                                    @else
                                        <img src="{{ asset($brosur->file) }}" class="img-fluid img-thumbnail" alt="Brosur Image">
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada brosur untuk produk ini.</p>
                    @endif
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali ke Daftar Produk</a>
            </div>
        </div>
    </div>
</div>
@endsection
