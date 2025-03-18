@extends('layouts.member.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Buat Tiket Baru</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('member.ticketing.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="service_type" class="form-label">Jenis Layanan</label>
                    <select name="service_type" id="service_type" class="form-select @error('service_type') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Jenis Layanan</option>
                        <option value="Permintaan Data" {{ old('service_type') == 'Permintaan Data' ? 'selected' : '' }}>Permintaan Data</option>
                        <option value="Maintenance" {{ old('service_type') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Visit" {{ old('service_type') == 'Visit' ? 'selected' : '' }}>Visit</option>
                        <option value="Installasi" {{ old('service_type') == 'Installasi' ? 'selected' : '' }}>Installasi</option>
                    </select>
                    @error('service_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
                
                <div class="mb-3">
                    <label for="submission_description" class="form-label">Keterangan Pengajuan</label>
                    <textarea name="submission_description" class="form-control @error('submission_description') is-invalid @enderror" rows="5" required>{{ old('submission_description') }}</textarea>
                    @error('submission_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="supporting_document" class="form-label">Dokumen Pendukung</label>
                    <input 
                        type="file" 
                        name="supporting_documents[]" 
                        id="supporting_document" 
                        class="form-control @error('supporting_documents.*') is-invalid @enderror" 
                        multiple
                    >
                    @error('supporting_documents.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('member.ticketing.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const serviceTypeSelect = document.getElementById('service_type');
    const otherServiceTypeContainer = document.getElementById('other_service_type_container');
    const otherServiceTypeInput = document.getElementById('other_service_type');

    serviceTypeSelect.addEventListener('change', function () {
        if (this.value === 'Lainnya') {
            otherServiceTypeContainer.classList.remove('d-none');
            otherServiceTypeInput.required = true; // Wajib diisi jika "Lainnya" dipilih
        } else {
            otherServiceTypeContainer.classList.add('d-none');
            otherServiceTypeInput.required = false; // Tidak wajib jika bukan "Lainnya"
            otherServiceTypeInput.value = ''; // Reset nilai jika bukan "Lainnya"
        }
    });
});

</script>
@endsection
