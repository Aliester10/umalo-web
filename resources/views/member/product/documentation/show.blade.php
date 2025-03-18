@extends('layouts.member.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="h4 mb-0">Detail Dokumentasi</h2>
        </div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ $documentation->status }}</p>
            <p><strong>Tanggal Dibuat:</strong> {{ $documentation->created_at->format('d-m-Y') }}</p>

            @if($documentation->files->isEmpty())
                <div class="alert alert-warning">
                    Tidak ada file untuk dokumentasi ini.
                </div>
            @else
                <div class="row g-3">
                    @foreach($documentation->files as $file)
                        @php
                            $extension = pathinfo($file->file, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($extension, ['jpeg', 'jpg', 'png', 'gif']))
                        <div class="col-md-4">
                            <div class="card">
                                <a href="{{ asset($file->file) }}" target="_blank">
                                    <img src="{{ asset($file->file) }}" alt="Dokumentasi" class="card-img-top" style="height: 200px; object-fit: cover;">
                                </a>
                            </div>
                        </div>
                        
                        @else
                            <div class="col-md-4">
                                <div class="card">
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
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('member.product.documentation.list', $documentation->userProduct->id) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
