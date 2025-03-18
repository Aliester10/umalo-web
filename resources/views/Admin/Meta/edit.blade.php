@extends('layouts.admin.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4 class="mb-0">Edit Meta</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.meta.update', $meta->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Metode PUT untuk meng-update data --}}

                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Judul</label>
                            <input type="text" name="title" class="form-control" value="{{ $meta->title }}" required>
                        </div>

                        <div class="form-group">
                            <label for="type" class="font-weight-bold">Tipe</label>
                            <select name="type" class="form-control" required>
                                <option value="announcement" {{ $meta->type == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="promotion" {{ $meta->type == 'promotion' ? 'selected' : '' }}>Promosi</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date" class="font-weight-bold">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $meta->start_date }}" required>
                            </div>
                        </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="font-weight-bold">Tanggal Berakhir</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $meta->end_date }}" required>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="content" class="font-weight-bold">Konten</label>
                            <textarea id="froala-editor" name="content">{{ $meta->content }}</textarea>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                new FroalaEditor('#froala-editor', {
                                    imageUploadURL: '{{ route('froala.upload_image') }}',  // Rute untuk upload gambar
                                    imageUploadParams: {
                                        _token: '{{ csrf_token() }}'  // Token CSRF untuk keamanan
                                    },
                                    toolbarButtons: [
                                        'bold', 'italic', 'underline', 'strikeThrough', 'align', 'formatOL', 'formatUL',
                                        'insertLink', 'insertImage', 'insertVideo', 'insertTable', 'html', 'undo', 'redo',
                                        'paragraphFormat', 'paragraphStyle', 'quote', 'fontFamily', 'fontSize',
                                        'textColor', 'backgroundColor', 'inlineStyle', 'subscript', 'superscript',
                                        'outdent', 'indent', 'clearFormatting', 'insertHR', 'fullscreen'
                                    ],
                                    heightMin: 300,
                                    heightMax: 500,
                                    imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
                                });
                            });
                        </script>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">Simpan Meta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.12/css/froala_editor.pkgd.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.12/js/froala_editor.pkgd.min.js"></script>
