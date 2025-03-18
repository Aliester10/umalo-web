@extends('layouts.member.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Edit Tiket</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('member.ticketing.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="service_type" class="form-label">Jenis Layanan</label>
                    <input type="text" name="service_type" class="form-control @error('service_type') is-invalid @enderror" value="{{ $ticket->service_type }}" required>
                    @error('service_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="submission_description" class="form-label">Deskripsi</label>
                    <textarea name="submission_description" class="form-control @error('submission_description') is-invalid @enderror" rows="5" required>{{ $ticket->submission_description }}</textarea>
                    @error('submission_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="supporting_document" class="form-label">Dokumen Pendukung</label>
                
                    <!-- Input File -->
                    <input 
                        type="file" 
                        name="supporting_document[]" 
                        id="supporting_document" 
                        class="form-control @error('supporting_document.*') is-invalid @enderror" 
                        multiple
                    >
                    @error('supporting_document.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                
                    <!-- Tampilkan Dokumen Jika Ada -->
                    @if (!empty($ticket->supporting_document))
                        <div class="mt-2">
                            <label class="form-label fw-bold">Dokumen yang Terunggah:</label>
                            <div class="row g-3" id="uploadedDocumentsContainer">
                                @php
                                    $documents = is_array(json_decode($ticket->supporting_document, true)) 
                                                 ? json_decode($ticket->supporting_document, true) 
                                                 : [$ticket->supporting_document];
                                @endphp
                                @foreach ($documents as $index => $document)
                                    <div class="col-6 col-md-3 d-flex flex-column align-items-center document-item" data-index="{{ $index }}">
                                        @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $document))
                                            <img src="{{ asset($document) }}" alt="Dokumen Pendukung" class="img-thumbnail" style="max-width: 100%; height: auto;">
                                        @elseif (preg_match('/\.pdf$/i', $document))
                                            <a href="{{ asset($document) }}" target="_blank" class="btn btn-link">Lihat PDF</a>
                                        @else
                                            <span class="text-muted">Tipe file tidak dikenali: {{ basename($document) }}</span>
                                        @endif
                                        <button class="btn btn-danger btn-sm mt-2 btn-delete-document" 
                                                data-url="{{ route('member.ticketing.removeDocument', [$ticket->id, $index]) }}">
                                            Hapus
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('member.ticketing.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('uploadedDocumentsContainer');

        container.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-delete-document')) {
                const button = event.target;
                const url = button.getAttribute('data-url');
                const parent = button.closest('.document-item');

                // Konfirmasi Penghapusan
                if (!confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
                    return;
                }

                // Kirim Permintaan AJAX
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal menghapus dokumen.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Hapus elemen dari DOM
                        parent.remove();

                        // Menampilkan pesan sukses di tempat
                        const successMessage = document.createElement('div');
                        successMessage.className = 'alert alert-success mt-3';
                        successMessage.textContent = data.message;
                        container.insertAdjacentElement('beforebegin', successMessage);

                        // Hilangkan pesan setelah 3 detik
                        setTimeout(() => successMessage.remove(), 3000);
                    } else {
                        // Menampilkan pesan error di tempat
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'alert alert-danger mt-3';
                        errorMessage.textContent = data.message || 'Gagal menghapus dokumen.';
                        container.insertAdjacentElement('beforebegin', errorMessage);

                        // Hilangkan pesan setelah 3 detik
                        setTimeout(() => errorMessage.remove(), 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Menampilkan pesan error jika terjadi masalah jaringan
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'alert alert-danger mt-3';
                    errorMessage.textContent = 'Terjadi kesalahan saat menghapus dokumen.';
                    container.insertAdjacentElement('beforebegin', errorMessage);

                    // Hilangkan pesan setelah 3 detik
                    setTimeout(() => errorMessage.remove(), 3000);
                });
            }
        });
    });
</script>


@endsection
