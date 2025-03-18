@extends('layouts.admin.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Semua Slider</h1>
            <a href="{{ route('admin.banner.create') }}" class="btn btn-primary">Tambah Slider Baru</a>
        </div>
        <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Sub-judul</th>
                        <th>Deskripsi</th>
                        <th>Teks Tombol</th>
                        <th>URL Tombol</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $slider)
                        <tr>
                            <td>{{ $slider->id }}</td>
                            <td><img src="{{ asset($slider->image_url) }}" alt="slider image" class="img-thumbnail" style="max-width: 100px; height: auto;"></td>
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->subtitle }}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ Str::limit($slider->description, 50) }}</td>
                            <td>{{ $slider->button_text }}</td>
                            <td>{{ $slider->button_url }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.banner.edit', $slider->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.banner.destroy', $slider->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this slider?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
    </div>
</div>
@endsection
