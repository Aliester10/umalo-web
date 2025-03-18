@extends('layouts.distributor.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Ajukan Negosiasi untuk Quotation</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('distributor.quotations.negotiation.store', $quotation->id) }}" method="POST">
                    @csrf
                    <!-- Quotation Information -->
                    <h5>Informasi Quotation</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Nomor Quotation</th>
                            <td>{{ $quotation->quotation_number }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Pengajuan</th>
                            <td>{{ $quotation->application_number }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $quotation->status == 'approved' ? 'success' : 'warning' }}">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Quotation</th>
                            <td>{{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d F Y') }}</td>
                        </tr>
                    </table>

                    <!-- Product Details -->
                    <h5 class="mt-4">Produk dalam Quotation</h5>
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
                            @foreach ($quotation->products as $index => $product)
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

                    <!-- Pricing Summary -->
                    <h5 class="mt-4">Ringkasan Harga</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Sub Total</th>
                            <td>Rp {{ number_format($quotation->subtotal_price, 2, ',', '.') }}</td>
                        </tr>
                        @if ($quotation->discount > 0)
                        <tr>
                            <th>Diskon ({{ $quotation->discount }}%)</th>
                            <td>- Rp {{ number_format($quotation->subtotal_price * ($quotation->discount / 100), 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>PPN ({{ $quotation->ppn }}%)</th>
                            <td>Rp {{ number_format($quotation->total_after_discount * ($quotation->ppn / 100), 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td><strong>Rp {{ number_format($quotation->grand_total, 2, ',', '.') }}</strong></td>
                        </tr>
                    </table>

                    <!-- Distributor Notes -->
                    <div class="mt-4">
                        <label for="distributor_notes" class="form-label">Catatan Distributor</label>
                        <textarea name="distributor_notes" id="distributor_notes" rows="4" class="form-control shadow-sm" placeholder="Jelaskan alasan negosiasi Anda" required></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('distributor.quotations.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Ajukan Negosiasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
