@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="h4 mb-0">Detail Dokumentasi</h2>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <p><strong>Status:</strong> {{ $documentation->status }}</p>
                <p><strong>Tanggal Dibuat:</strong> {{ $documentation->created_at->format('d-m-Y') }}</p>
            </div>

            @if($documentation->files->isEmpty())
                <div class="alert alert-warning">
                    Tidak ada file untuk dokumentasi ini.
                </div>
            @else
                <h4 class="mb-4">File Dokumentasi:</h4>
                <div class="row g-3">
                    @foreach($documentation->files as $file)
                        @php
                            $extension = pathinfo($file->file, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($extension, ['jpeg', 'jpg', 'png', 'gif']))
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <a href="{{ asset($file->file) }}" target="_blank">
                                    <img src="{{ asset($file->file) }}" alt="Dokumentasi" class="card-img-top" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-footer text-center bg-light">
                                    <small class="text-muted">Klik untuk melihat gambar</small>
                                </div>
                            </div>
                        </div>
                        @elseif(in_array($extension, ['pdf']))
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <iframe src="{{ asset($file->file) }}" frameborder="0" class="card-img-top" style="height: 200px; width: 100%;"></iframe>
                                <div class="card-footer text-center bg-light">
                                    <a href="{{ asset($file->file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat PDF</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <p>File tidak dapat ditampilkan.</p>
                                    <a href="{{ asset($file->file) }}" target="_blank" class="btn btn-primary btn-sm">Unduh File</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('members.products.documentation.list', $documentation->userProduct->id) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
