@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Dokumentasi untuk Produk: {{ $usersProduct->product->name }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('members.products.documentation.store', $usersProduct->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="status">Status Dokumentasi</label>
                    <input type="text" name="status" id="status" class="form-control" placeholder="Masukkan status" required>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="files">Unggah File Dokumentasi (PDF/Doc/Gambar)</label>
                    <input type="file" name="files[]" id="files" class="form-control" multiple>
                    @error('files.*')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Dokumentasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
