@extends('layouts.admin.master')

@section('content')
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h4">Aktivitas</h1>
            <a href="{{ route('admin.activity.create') }}" class="btn btn-primary">Tambah Aktivitas Baru</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Gambar</th>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td><img src="{{ asset($activity->images) }}" alt="{{ $activity->title }}" class="img-thumbnail" style="max-width: 100px; height: auto;"></td>
                                <td>{{ $activity->date->format('d-m-Y') }}</td>
                                <td>{{ $activity->title }}</td>
                                <td>{{ Str::limit($activity->description, 50) }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.activity.edit', $activity) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('admin.activity.show', $activity) }}" class="btn btn-sm btn-info">Lihat</a>
                                        <form action="{{ route('admin.activity.destroy', $activity) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
@endsection
