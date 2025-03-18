@extends('layouts.admin.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="card-title">Daftar Dokumentasi untuk Produk: {{ $usersProduct->product->name }}</h1>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <p><strong>Tanggal Pembelian:</strong> {{ $usersProduct->purchase_date ?? 'N/A' }}</p>

                    @if($usersProduct->documentations->isEmpty())
                        <p>Belum ada dokumentasi untuk produk ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usersProduct->documentations as $index => $documentation)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $documentation->status }}</td>
                                            <td>{{ $documentation->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <div class="dropdown documentation-actions-dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton-{{ $documentation->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu documentation-actions-menu" aria-labelledby="dropdownMenuButton-{{ $documentation->id }}">
                                                        <li>
                                                            <a href="{{ route('documentation.show', $documentation->id) }}" class="dropdown-item">
                                                                <i class="fas fa-eye me-2"></i> Lihat Detail
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('documentation.edit', $documentation->id) }}" class="dropdown-item">
                                                                <i class="fas fa-edit me-2"></i> Edit Dokumentasi
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('documentation.destroy', $documentation->id) }}" method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Anda yakin ingin menghapus dokumentasi ini?');">
                                                                    <i class="fas fa-trash me-2"></i> Hapus Dokumentasi
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                    
                                                    <style>
                                                        /* Dropdown khusus untuk Documentation Actions */
                                                        .documentation-actions-dropdown .documentation-actions-menu {
                                                            position: fixed !important; /* Mengabaikan parent container */
                                                            z-index: 1050 !important;   /* Memastikan berada di atas elemen lain */
                                                            will-change: transform;    /* Memperbaiki posisi animasi jika ada */
                                                        }
                                            
                                                        /* Tambahkan spesifikasi jika perlu */
                                                        .documentation-actions-dropdown .dropdown-toggle {
                                                            cursor: pointer;
                                                        }
                                                    </style>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
