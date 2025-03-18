@extends('layouts.admin.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header">
                <h1 class="h4">Edit banner</h1>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label for="image_url">Gambar</label>
                        <input type="file" name="image_url" class="form-control">
                        <div class="mt-3">
                            <img src="{{ asset($banner->image_url) }}" alt="banner image" class="img-thumbnail" style="max-width: 150px; height: auto;">
                        </div>
                        @error('image_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="title">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ $banner->title }}" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="subtitle">Sub-judul</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ $banner->subtitle }}" required>
                        @error('subtitle')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ $banner->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="button_text">Teks Tombol</label>
                        <input type="text" name="button_text" class="form-control" value="{{ $banner->button_text }}" required>
                        @error('button_text')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="button_url">URL Tombol</label>
                        <select name="button_url" class="form-control" required>
                            <option value="">Pilih rute yang telah ditentukan atau aktivitas</option>

                            <!-- Predefined Routes -->
                            @foreach ($routes as $name => $url)
                                <option value="{{ $url }}" {{ $banner->button_url == $url ? 'selected' : '' }}>
                                    {{ ucfirst($name) }} (Predefined)
                                </option>
                            @endforeach

                            <!-- Dynamic Activities -->
                            @foreach ($activities as $activity)
                                <option value="{{ route('activity.show', $activity->id) }}"
                                    {{ $banner->button_url == route('activity.show', $activity->id) ? 'selected' : '' }}>
                                    {{ $activity->title }} (Activity)
                                </option>
                            @endforeach

                            <!-- Meta -->
                            @foreach ($metas as $meta)
                                <option value="{{ route('member.meta.show', $meta->slug) }}"
                                    {{ $banner->button_url == route('member.meta.show', $meta->slug) ? 'selected' : '' }}>
                                    {{ $meta->title }} (Meta)
                                </option>
                            @endforeach

                            <!-- Products -->
                            @foreach ($products as $product)
                            <option value="{{ route('product.show', $product->slug) }}"
                                {{ $banner->button_url == route('product.show', $product->slug) ? 'selected' : '' }}>
                                {{ $product->name }} (Product)
                            </option>
                        @endforeach
                        

                        </select>
                        @error('button_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Perbaharui banner</button>
                        <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
