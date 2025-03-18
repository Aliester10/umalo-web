@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2>Edit Produk : {{ $product->nama }}</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                    <div class="form-group mb-3">
                                        <label for="name">Nama product :</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="brand">Merk product :</label>
                                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="usage">Kegunaan product :</label>
                                        <textarea name="usage" class="form-control" required>{{ old('usage', $product->usage) }}</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="category_id">Kategori :</label>
                                        <select name="category_id" class="form-control" required>
                                            @foreach ($category as $catergories)
                                                <option value="{{ $catergories->id }}" {{ old('category_id', $product->category_id) == $catergories->id ? 'selected' : '' }}>
                                                    {{ $catergories->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="ekatalog">Link Ekatalog :</label>
                                        <input type="text" name="ekatalog" class="form-control" value="{{ old('ekatalog', $product->ekatalog) }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="images">Gambar product :</label>
                                        <input type="file" name="images[]" class="form-control" multiple>
                                        <small class="form-text text-muted">Unggah beberapa gambar product jika diperlukan.</small>

                                        <!-- Display current images -->
                                        @if($product->images)
                                            <div class="mt-2">
                                                @foreach($product->images as $image)
                                                    <div class="d-inline-block text-center mb-3">
                                                        <img src="{{ asset($image->images) }}" alt="Gambar product" style="max-width: 100px; margin-right: 10px;">
                                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"> Hapus
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- User Manual Tab -->
                            <div class="tab-pane fade" id="user-manual" role="tabpanel" aria-labelledby="user-manual-tab">
                                <div class="card p-3 mb-4">
                                    <div class="form-group mb-3">
                                        <label for="video">Video Tutorial (MP4, AVI, MKV)</label>
                                        <input type="file" class="form-control" name="video[]" id="video" accept="video/*" multiple>
                                        <small class="form-text text-muted">Unggah beberapa video tutorial product jika diperlukan.</small>

                                        <!-- Display current videos -->
                                        @if($product->videos)
                                            <div class="mt-2">
                                                @foreach($product->videos as $video)
                                                    <div class="d-inline-block text-center mb-3">
                                                        <video width="200" controls>
                                                            <source src="{{ asset($video->video) }}" type="video/mp4">
                                                                Browser Anda tidak mendukung tag video.
                                                        </video>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="file_usermanual">Panduan Penggunaan (PDF/DOC)</label>
                                        <input type="file" class="form-control" name="file_usermanual[]" id="file_usermanual" multiple>
                                        @error('file_usermanual.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    
                                        @if($product->userManual && $product->userManual->count())
                                            <ul>
                                                @foreach($product->userManual as $doc)
                                                    <li>
                                                        <a href="{{ asset($doc->file) }}" target="_blank">Lihat User Manual</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>

                            <!-- Brosur Tab -->
                            <div class="tab-pane fade" id="brosur" role="tabpanel" aria-labelledby="brosur-tab">
                                <div class="card p-3 mb-4">
                                    <div class="form-group mb-3">
                                        <label for="file">Brosur (PDF/Image)</label>
                                        <input type="file" class="form-control" id="file" name="file[]" multiple>
                                        @error('file')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        @if($product->brosur && $product->brosur->count())
                                            <ul>
                                                @foreach($product->brosur as $document)
                                                    <li>
                                                        <a href="{{ asset($document->file) }}" target="_blank">Lihat Brosur</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">Tidak ada brosur yang tersedia.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success mt-3">Perbaharui product</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
