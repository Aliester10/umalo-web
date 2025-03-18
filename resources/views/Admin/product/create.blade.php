@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Buat Produk Baru</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">Umum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="user-manual-tab" data-toggle="tab" href="#user-manual" role="tab" aria-controls="user-manual" aria-selected="false">Panduan Penggunaan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="brosur-tab" data-toggle="tab" href="#brosur" role="tab" aria-controls="brosur" aria-selected="false">Brosur</a>
                            </li>
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content">
                            <!-- General Tab -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="card p-3 mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama Produk :</label>
                                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="brand">Merek Produk :</label>
                                                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="usage">Kegunaan Produk :</label>
                                        <textarea name="usage" class="form-control" required>{{ old('usage') }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category_id">Kategori :</label>
                                                <select name="category_id" class="form-control" required>
                                                    @foreach ($category as $categories)
                                                        <option value="{{ $categories->id }}" {{ old('category_id') == $categories->id ? 'selected' : '' }}>
                                                            {{ $categories->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="form-group">
                                            <label for="ekatalog">Link Ekatalog :</label>
                                            <input type="text" name="ekatalog" class="form-control" value="{{ old('ekatalog') }}" required>
                                        </div>

                                    <div class="form-group">
                                        <label for="images">Gambar Produk :</label>
                                        <input type="file" name="images[]" class="form-control" multiple required>
                                        <small class="form-text text-muted">Unggah beberapa gambar produk jika diperlukan.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- User Manual Tab -->
                            <div class="tab-pane fade" id="user-manual" role="tabpanel" aria-labelledby="user-manual-tab">
                                <div class="card p-3 mb-4">
                                    <div class="form-group">
                                        <label for="video">Video Tutorial (MP4, AVI, MKV)</label>
                                        <input type="file" class="form-control" name="video[]" id="video" accept="video/*" multiple>
                                        <small class="form-text text-muted">Unggah beberapa video tutorial produk jika diperlukan.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="file_usermanual">Panduan Penggunaan (PDF/DOC)</label>
                                        <input type="file" class="form-control" name="file_usermanual[]" id="file_usermanual">
                                    </div>
                                </div>
                            </div>


                            <!-- Brosur Tab -->
                            <div class="tab-pane fade" id="brosur" role="tabpanel" aria-labelledby="brosur-tab">
                                <div class="card p-3 mb-4">
                                    <div class="form-group">
                                        <label for="file">Brosur (PDF/Image)</label>
                                        <input type="file" class="form-control" id="file" name="file[]" multiple>
                                        <small class="form-text text-muted">Unggah beberapa file brosur (PDF atau gambar).</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success mt-3">Simpan Produk</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
