@extends('layouts.member.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h1 class="h4">Daftar Produk</h1>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('member.products.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama produk..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary me-2">Cari</button>
                            <a href="{{ route('member.products.index') }}" class="btn btn-secondary" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if($userProduct->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Anda belum memiliki produk.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userProduct as $index => $product)
                                    @php
                                        $firstImage = $product->product->images->first();
                                        $imageSrc = $firstImage ? $firstImage->images : 'assets/img/default.jpg';
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{ asset($imageSrc) }}" alt="{{ $product->product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                        </td>
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->purchase_date ?? 'N/A' }}</td>
                                        <td>{{ $product->quantity ?? 1 }}</td>
                                        <td>
                                            <div class="dropdown product-actions-dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton-{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu product-actions-menu" aria-labelledby="dropdownMenuButton-{{ $product->id }}">
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">
                                                            <i class="fas fa-eye me-2"></i> Lihat
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('member.product.documentation.list', $product->id) }}" class="dropdown-item">
                                                            <i class="fas fa-book me-2"></i> Dokumentasi
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            {{-- Modal --}}
                                            <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel-{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h5 class="modal-title" id="productModalLabel-{{ $product->id }}">{{ $product->product->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-4 align-items-center">
                                                                <div class="col-md-4">
                                                                    <img src="{{ asset($imageSrc) }}" alt="{{ $product->product->name }}" class="img-fluid rounded shadow">
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <table class="table table-striped table-hover">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row" class="text-muted" style="width: 40%;">Tanggal Pembelian</th>
                                                                                <td>{{ $product->purchase_date ?? 'N/A' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row" class="text-muted" style="width: 40%;">Jumlah</th>
                                                                                <td>{{ $product->quantity }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            @if($product->product->videos->isNotEmpty())
                                                            <h5 class="mt-4">Videos</h5>
                                                            <div class="row row-cols-1 row-cols-md-3 g-3">
                                                                @foreach($product->product->videos as $index => $video)
                                                                    <div class="col">
                                                                        <a href="{{ asset($video->video) }}" target="_blank" class="btn btn-primary w-100">
                                                                            <i class="fas fa-play-circle"></i> Lihat Video {{ $index + 1 }}
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @endif

                                                            @if($product->product->userManual->isNotEmpty())
                                                            <h5 class="mt-4">User Manual</h5>
                                                            <div class="row row-cols-1 row-cols-md-3 g-3">
                                                                @foreach($product->product->userManual as $manual)
                                                                    <div class="col">
                                                                        @php
                                                                            $extension = pathinfo($manual->file, PATHINFO_EXTENSION);
                                                                        @endphp
                                                                        @if($extension === 'pdf')
                                                                            <a href="{{ asset($manual->file) }}" target="_blank" class="btn btn-primary btn-sm w-100">
                                                                                <i class="fas fa-file-pdf"></i> Lihat PDF
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ asset($manual->file) }}" target="_blank" class="btn btn-secondary btn-sm w-100">
                                                                                <i class="fas fa-download"></i> Unduh User Manual
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @endif

                                                            @if($product->product->brosur->isNotEmpty())
                                                            <h5 class="mt-4">Brosur</h5>
                                                            <div class="row row-cols-1 row-cols-md-3 g-3">
                                                                @foreach($product->product->brosur as $brosur)
                                                                    <div class="col">
                                                                        @php
                                                                            $extension = pathinfo($brosur->file, PATHINFO_EXTENSION);
                                                                        @endphp
                                                                        @if(in_array($extension, ['jpeg', 'jpg', 'png', 'gif']))
                                                                            <a href="{{ asset($brosur->file) }}" target="_blank">
                                                                                <img src="{{ asset($brosur->file) }}" alt="Brosur" class="img-fluid rounded shadow" style="width: 100%; height: auto;">
                                                                            </a>
                                                                        @elseif($extension === 'pdf')
                                                                            <a href="{{ asset($brosur->file) }}" target="_blank" class="btn btn-primary btn-sm w-100">
                                                                                <i class="fas fa-file-pdf"></i> Lihat PDF
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ asset($brosur->file) }}" target="_blank" class="btn btn-secondary btn-sm w-100">
                                                                                <i class="fas fa-download"></i> Unduh File
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- End Modal --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    {{-- Tombol Previous --}}
                                    @if ($userProduct->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $userProduct->previousPageUrl() }}" aria-label="Previous">Previous</a>
                                        </li>
                                    @endif
                        
                                    {{-- Tombol Halaman --}}
                                    @for ($page = 1; $page <= $userProduct->lastPage(); $page++)
                                        @if ($page == $userProduct->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $userProduct->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endfor
                        
                                    {{-- Tombol Next --}}
                                    @if ($userProduct->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $userProduct->nextPageUrl() }}" aria-label="Next">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
