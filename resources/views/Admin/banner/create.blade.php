@extends('layouts.admin.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header">
                <h1 class="h4">Buat Slider Baru</h1>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="image_url">Gambar</label>
                        <input type="file" name="image_url" class="form-control">
                        @error('image_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Sub-judul</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
                        @error('subtitle')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="button_text">Teks Tombol</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text') }}">
                        @error('button_text')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="button_url">URL Tombol</label>
                        <select name="button_url" class="form-control">
                            <option value="">Pilih rute/aktivitas</option>

                            <!-- Predefined Routes -->
                            @foreach ($routes as $name => $url)
                            <option value="{{ $url }}" {{ old('button_url') == $url ? 'selected' : '' }}>
                                {{ ucfirst($name) }} (Predefined)
                            </option>
                            @endforeach

                            <!-- Dynamic Activities -->
                            @foreach ($activities as $activity)
                            <option value="{{ route('activity.show', $activity->id) }}" 
                                {{ old('button_url') == route('activity.show', $activity->id) ? 'selected' : '' }}>
                                {{ $activity->title }} (Activity)
                            </option>
                            @endforeach

                            <!-- Meta -->
                            @foreach ($metas as $meta)
                            <option value="{{ route('member.meta.show', $meta->slug) }}" 
                                {{ old('button_url') == route('member.meta.show', $meta->slug) ? 'selected' : '' }}>
                                {{ $meta->title }} (Meta)
                            </option>
                            @endforeach

                            <!-- Products -->
                            @foreach ($products as $product)
                            <option value="{{ route('product.show', $product->slug) }}" 
                                {{ old('button_url') == route('product.show', $product->slug) ? 'selected' : '' }}>
                                {{ $product->name }} (Product)
                            </option>
                        @endforeach
                        

                        </select>
                        @error('button_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm mt-3">Buat Slider</button>
                </form>
            </div>
        </div>
    </div>
@endsection
