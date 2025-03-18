@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3 shadow">
            <h2>Detail Produk : {{ $products->nama }}</h2>

            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h5 class="card-title">Informasi Produk</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Nama</th>
                                <td>{{ $products->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Merek</th>
                                <td>{{ $products->brand }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kegunaan</th>
                                <td>{{ $products->usage }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Link</th>
                                <td>{{ $products->ekatalog }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kategori</th>
                                <td>{{ $products->category->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Gambar Produk -->
            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h5 class="card-title">Gambar Produk</h5>
                    @if($products->images->count())
                        <div class="row">
                            @foreach($products->images as $images)
                                <div class="col-md-3">
                                    <img src="{{ asset($images->images) }}" class="img-fluid img-thumbnail" alt="Gambar Produk">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Tidak ada gambar untuk produk ini.</p>
                    @endif
                </div>
            </div>

            <!-- Video Produk -->
            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h5 class="card-title">Video Produk</h5>
                    @if($products->videos->count())
                        <div class="row">
                            @foreach($products->videos as $video)
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

            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h5 class="card-title">User Manual</h5>
                    @if($products->userManual->count())
                        <ul>
                            @foreach($products->userManual as $doc)
                                <li>
                                    <a href="{{ asset($doc->file) }}" target="_blank">Lihat User Manual PDF</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada User Manual untuk produk ini.</p>
                    @endif
                </div>
            </div>

            <!-- Brosur Produk -->
            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h5 class="card-title">Brosur</h5>
                    @if($products->brosur->count())
                        <ul>
                            @foreach($products->brosur as $brosur)
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
                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Kembali ke Daftar Produk</a>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
