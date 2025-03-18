@extends('layouts.admin.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">

        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('members.create') }}" class="btn btn-transparent btn-create-ticket">
                <i class="fas fa-plus me-2"></i> Tambah Member
            </a>
        </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Judul di sebelah kiri -->
                    <div class="card-title">
                        <h1>Daftar Member</h1>
                    </div>
                
                    <!-- Pencarian dan tombol refresh di sebelah kanan -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Form Pencarian -->
                        <form method="GET" action="{{ route('members.index') }}" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Cari Member..." value="{{ request('name') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                
                        <!-- Tombol Refresh -->
                        <a href="{{ route('members.index') }}" class="btn btn-secondary" title="Refresh">
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->company_name }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td>{{ $member->address }}</td>
                                        <td>
                                            <div class="dropdown member-actions-dropdown" data-bs-display="static">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="memberActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu member-actions-menu dropdown-menu-end" aria-labelledby="memberActionsDropdown">
                                                    <li>
                                                        <a href="{{ route('members.show', $member->id) }}" class="dropdown-item">
                                                            <i class="fas fa-eye"></i> Lihat Data
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('members.edit', $member->id) }}" class="dropdown-item">
                                                            <i class="fas fa-edit"></i> Edit Data
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this member?');">
                                                                <i class="fas fa-trash"></i> Delete Data
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('members.add-products', $member->id) }}" class="dropdown-item">
                                                            <i class="fas fa-plus"></i> Tambah Produk Member
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('members.edit-products', $member->id) }}" class="dropdown-item">
                                                            <i class="fas fa-pencil-alt"></i> Edit Produk Member
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <style>
                                            /* Dropdown khusus untuk Member Actions */
                                        .member-actions-dropdown .member-actions-menu {
                                            position: fixed !important; /* Mengabaikan parent container */
                                            z-index: 1050 !important;   /* Memastikan berada di atas elemen lain */
                                            will-change: transform;    /* Memperbaiki posisi animasi jika ada */
                                        }

                                        /* Tambahkan spesifikasi jika perlu */
                                        .member-actions-dropdown .dropdown-toggle {
                                            cursor: pointer;
                                        }
                                        </style>                                                                              
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{-- Tombol Previous --}}
                                @if ($members->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $members->previousPageUrl() }}" aria-label="Previous">Previous</a>
                                    </li>
                                @endif
                    
                                {{-- Tombol Halaman --}}
                                @for ($page = 1; $page <= $members->lastPage(); $page++)
                                    @if ($page == $members->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $members->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor
                    
                                {{-- Tombol Next --}}
                                @if ($members->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $members->nextPageUrl() }}" aria-label="Next">Next</a>
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
</div>
@endsection
