@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('admin.product.create') }}" class="btn btn-transparent btn-create-ticket">
            <i class="fas fa-plus me-2"></i> Tambah Produk
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Judul di sebelah kiri -->
                    <div class="card-title">
                        <h1>Produk</h1>
                    </div>
                
                    <!-- Pencarian dan tombol refresh di sebelah kanan -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Form Pencarian -->
                        <form method="GET" action="{{ route('admin.product.index') }}" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Cari produk..." value="{{ request('name') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                
                        <!-- Tombol Refresh -->
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
                
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Merk</th>
                                        <th>Kategori</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                            <td class="text-truncate" style="max-width: 150px;">{{ $product->name }}</td>
                                            <td class="text-truncate" style="max-width: 100px;">{{ $product->brand }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>
                                                @if ($product->images->isNotEmpty())
                                                    <img src="{{ asset($product->images->first()->images) }}" class="img-fluid w-100" alt="{{ $product->name }}" style="max-width: 250px; height: auto;">
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-info btn-sm">Tampilkan</a>
                                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus product ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Produk tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <nav>
                        <ul class="pagination">
                            {{-- Tombol Previous --}}
                            @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">Previous</a>
                                </li>
                            @endif
                
                            {{-- Tombol Halaman --}}
                            @for ($page = 1; $page <= $products->lastPage(); $page++)
                                @if ($page == $products->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endfor
                
                            {{-- Tombol Next --}}
                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
