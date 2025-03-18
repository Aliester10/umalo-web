@extends('layouts.admin.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Negosiasi</h4>
                @if ($negotiation->status !== 'close')
                    <form action="{{ route('admin.quotations.negotiation.complete', $negotiation->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan negosiasi ini?')">
                            Tutup Negosiasi
                        </button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                <h5>Informasi Negosiasi</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Nomor Quotation</th>
                        <td>{{ $negotiation->quotation->quotation_number }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Pengajuan</th>
                        <td>{{ $negotiation->quotation->application_number }}</td>
                    </tr>
                    <tr>
                        <th>Status Negosiasi</th>
                        <td>{{ ucfirst($negotiation->status) }}</td>
                    </tr>
                    <tr>
                        <th>Catatan Distributor</th>
                        <td>{{ $negotiation->distributor_notes }} <span class="text-muted">(Catatan Terakhir)</span></td>
                    </tr>
                    <tr>
                        <th>Catatan Admin</th>
                        <td>
                            @if (!empty($negotiation->admin_notes))
                                {{ $negotiation->admin_notes }} <span class="text-muted">(Catatan Terakhir)</span>
                            @else
                                <div class="alert alert-info m-0 p-2">
                                    <i class="fas fa-info-circle"></i> Belum ada catatan dari admin.
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- Admin Notes Form -->
                @if ($negotiation->status !== 'close')
                    <form action="{{ route('admin.quotations.negotiation.update', $negotiation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Catatan Admin</label>
                            <textarea name="admin_notes" id="admin_notes" rows="4" class="form-control shadow-sm" placeholder="Tambahkan catatan untuk distributor" required>{{ old('admin_notes', $negotiation->admin_notes) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">
                        <strong>Informasi:</strong> Negosiasi sudah ditutup dan tidak dapat diperbarui.
                    </div>
                @endif


                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

                
                
            </div>
        </div>
    </div>
</div>
@endsection
