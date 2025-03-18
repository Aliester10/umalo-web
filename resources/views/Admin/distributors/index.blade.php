@extends('layouts.admin.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('distributors.create') }}" class="btn btn-transparent btn-create-ticket">
            <i class="fas fa-plus me-2"></i> Tambah Distributor
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Judul di sebelah kiri -->
                    <div class="card-title">
                        <h1>Daftar Distributor</h1>
                    </div>
                
                    <!-- Pencarian dan tombol refresh di sebelah kanan -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Form Pencarian -->
                        <form method="GET" action="{{ route('distributors.index') }}" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Cari Distributor..." value="{{ request('name') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                
                        <!-- Tombol Refresh -->
                        <a href="{{ route('distributors.index') }}" class="btn btn-secondary" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
                                    <th>Konfirmasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distributors as $distributor)
                                    <tr>
                                        <td>{{ $distributor->name }}</td>
                                        <td>{{ $distributor->email }}</td>
                                        <td>{{ $distributor->company_name }}</td>
                                        <td>{{ $distributor->phone }}</td>
                                        <td>{{ $distributor->address }}</td>
                                        <td>
                                            <span class="badge {{ $distributor->is_verified ? 'bg-success' : 'bg-danger' }}">
                                                {{ $distributor->is_verified ? 'Terverifikasi' : 'Tidak Terverifikasi' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('distributors.show', $distributor->id) }}" class="btn btn-info btn-sm mt-1">
                                                <i class="fas fa-eye"></i> Lihat Data
                                            </a>
                                            <a href="{{ route('distributors.edit', $distributor->id) }}" class="btn btn-warning btn-sm mt-1">
                                                <i class="fas fa-edit"></i> Edit Data
                                            </a>
                                            <form action="{{ route('distributors.destroy', $distributor->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Are you sure you want to delete this distributor?');">
                                                    <i class="fas fa-trash"></i> Delete Data
                                                </button>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{-- Tombol Previous --}}
                                @if ($distributors->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $distributors->previousPageUrl() }}" aria-label="Previous">Previous</a>
                                    </li>
                                @endif
                    
                                {{-- Tombol Halaman --}}
                                @for ($page = 1; $page <= $distributors->lastPage(); $page++)
                                    @if ($page == $distributors->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $distributors->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor
                    
                                {{-- Tombol Next --}}
                                @if ($distributors->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $distributors->nextPageUrl() }}" aria-label="Next">Next</a>
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
