@extends('layouts.admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="h4 mb-0">Edit Dokumentasi</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('documentation.update', $documentation->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="status">Status Dokumentasi</label>
                                <input type="text" name="status" id="status" class="form-control" value="{{ $documentation->status }}" required>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="files">Unggah File Baru (Opsional)</label>
                                <input type="file" name="files[]" id="files" class="form-control" multiple>
                                @error('files.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if($documentation->files->isNotEmpty())
                                <h5>File Dokumentasi Saat Ini:</h5>
                                <div class="row">
                                    @foreach($documentation->files as $file)
                                        @php
                                            $extension = pathinfo($file->file, PATHINFO_EXTENSION);
                                        @endphp

                                        @if(in_array($extension, ['jpeg', 'jpg', 'png', 'gif']))
                                            <div class="col-md-4 mb-3">
                                                <div class="card shadow-sm">
                                                    <img src="{{ asset($file->file) }}" alt="Dokumentasi" class="card-img-top" style="height: 200px; object-fit: cover;">
                                                    <div class="card-footer text-center bg-light">
                                                        <small class="text-muted">{{ basename($file->file) }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-4 mb-3">
                                                <div class="card shadow-sm">
                                                    <div class="card-body text-center">
                                                        <p>File tidak dapat ditampilkan</p>
                                                        <a href="{{ asset($file->file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('members.products.documentation.list', $documentation->userProduct->id) }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
