@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('admin.category.create') }}" class="btn btn-transparent btn-create-ticket">
                <i class="fas fa-plus me-2"></i> Tambah Kategori
            </a>
        </div>
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Kategori List</h3>
                    <div class="d-flex gap-2">
                        <!-- Form Pencarian -->
                        <form method="GET" action="{{ route('admin.category.index') }}" class="d-flex">
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Cari berdasarkan nama..." value="{{ request('name') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                        <!-- Tombol Refresh -->
                        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Form Pencarian -->
                    

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category as $index => $categories)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $categories->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.category.edit', $categories->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.category.destroy', $categories->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Kategori tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
