@extends('layouts.admin.master')

@section('content')
    <div class="card shadow-lg">
        <div class="card-header">
            <h1 class="h4">Edit Activitas</h1>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.activity.update', $activity) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="images" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="images" name="images">
                    <img src="{{ asset($activity->images) }}" alt="{{ $activity->title }}" class="img-thumbnail mt-2" style="max-width: 100px; height: auto;">
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $activity->date->format('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $activity->title }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $activity->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
