@extends('layouts.distributor.master')

@section('content')
<div class="row justify-content-center">

    @if ($negotiation->status === 'close')
            <div class="alert alert-info mt-2">
                <i class="fas fa-info-circle"></i> Negosiasi telah ditutup. Anda harus mengajukan <strong>Purchase Order (PO)</strong> untuk melanjutkan proses.
            </div>
        @endif

        
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Detail Negosiasi Quotation</h4>
            </div>
            <div class="card-body">
                <!-- Quotation Information -->
                <h5>Informasi Quotation</h5>
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
                        <th>Status Quotation</th>
                        <td>
                            <span class="badge bg-{{ $negotiation->quotation->status == 'approved' ? 'success' : ($negotiation->quotation->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($negotiation->quotation->status) }}
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Negotiation Details -->
                <h5 class="mt-4">Detail Negosiasi</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Catatan Distributor</th>
                        @if ($negotiation->status !== 'close')
                            <td>
                                <form action="{{ route('distributor.quotations.negotiations.updateNotes', $negotiation->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="distributor_notes" class="form-label">Catatan Admin</label>
                                        <textarea name="distributor_notes" id="distributor_notes" rows="4" class="form-control shadow-sm" placeholder="Tambahkan catatan untuk distributor" required>{{ old('distributor_notes', $negotiation->distributor_notes) }}</textarea>
                                    </div>
                    
                                    <button type="submit" class="btn btn-primary mt-2">Perbarui Catatan</button>
                                </form>
                            </td>    
                            @else
                            <td>
                                {{ $negotiation->distributor_notes }} <span class="text-muted">(Catatan Terakhir)</span>
                            </td>           
                        @endif     
                    </tr>
                    <tr>
                        <th>Catatan Admin</th>
                        <td>
                            @if (!empty($negotiation->admin_notes))
                                {{ $negotiation->admin_notes }} <span class="text-muted">(Catatan Terakhir)</span>
                            @else
                                <div class="alert alert-info m-0 p-2">
                                    <i class="fas fa-info-circle"></i> Admin belum melihat pengajuan Anda. Mohon tunggu.
                                </div>
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <th>Status Negosiasi</th>
                        <td>
                            <span class="badge bg-{{ $negotiation->status == 'accepted' ? 'success' : ($negotiation->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($negotiation->status) }}
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Quotation Product Details -->
                <h5 class="mt-4">Produk yang Diajukan</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kuantitas</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($negotiation->quotation->products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img 
                                        src="{{ $product->product->images->first() ? asset($product->product->images->first()->images) : asset('default-image.jpg') }}" 
                                        alt="Gambar Produk" 
                                        width="50" 
                                        height="50"
                                    />
                                </td>
                                <td>{{ $product->product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>Rp {{ number_format($product->unit_price, 2, ',', '.') }}</td>
                                <td>Rp {{ number_format($product->quantity * $product->unit_price, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Back Button -->
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('distributor.quotations.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
