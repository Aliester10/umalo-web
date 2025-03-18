@extends('layouts.admin.master')

@section('content')
    <div class="card shadow-lg">
        <div class="card-header ">
            <h1 class="h4">Tambah Aktivitas Baru</h1>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.activity.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="images" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="images" name="images" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
