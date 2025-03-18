@extends('layouts.admin.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <!-- Alert untuk Error -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="h5 mb-0">Buat Proforma Invoice untuk PO #{{ $purchaseOrder->po_number }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.proformainvoice.store', $purchaseOrder->id) }}" method="POST">
                    @csrf

                    <!-- Vendor Information -->
                    <h5 class="mt-3 mb-3">Informasi Vendor</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="vendor_name" class="form-label">Nama Vendor</label>
                                <input type="text" class="form-control shadow-sm" id="vendor_name" name="vendor_name" value="{{ old('vendor_name', $user->company_name) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="vendor_address" class="form-label">Alamat Vendor</label>
                                <textarea class="form-control shadow-sm" id="vendor_address" name="vendor_address" rows="2" readonly>{{ old('vendor_address', $user->address) }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="vendor_phone" class="form-label">Nomor Telepon Vendor</label>
                                <input type="text" class="form-control shadow-sm" id="vendor_phone" name="vendor_phone" value="{{ old('vendor_phone', $user->phone) }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Product List -->
                    <h5 class="mt-4 mb-3">Daftar Produk</h5>
                    <div id="product-list">
                        @foreach($products as $index => $product)
                            <div class="row mb-3 align-items-end">
                                <div class="col-md-1">
                                    <label for="no-{{ $index }}" class="form-label">No</label>
                                    <input type="number" id="no-{{ $index }}" class="form-control shadow-sm" name="products[{{ $index }}][no]" value="{{ $index + 1 }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="name-{{ $index }}" class="form-label">Nama Produk</label>
                                    <input type="text" id="name-{{ $index }}" class="form-control shadow-sm" name="products[{{ $index }}][name]" value="{{ $product->product->name ?? 'Unknown Product' }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="qty-{{ $index }}" class="form-label">QTY</label>
                                    <input type="number" id="qty-{{ $index }}" class="form-control shadow-sm" name="products[{{ $index }}][qty]" value="{{ $product->quantity }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="unit_price-{{ $index }}" class="form-label">Harga Satuan</label>
                                    <input type="text" id="unit_price-{{ $index }}" class="form-control shadow-sm" name="products[{{ $index }}][unit_price]" value="Rp {{ number_format($product->unit_price, 0, ',', '.') }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="total_price-{{ $index }}" class="form-label">Total Harga</label>
                                    <input type="text" id="total_price-{{ $index }}" class="form-control shadow-sm" name="products[{{ $index }}][total_price]" value="Rp {{ number_format($product->quantity * $product->unit_price, 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Financial Information -->
                    <h5 class="mt-4 mb-3">Informasi Keuangan</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="subtotal" class="form-label">Subtotal</label>
                            <div class="form-control shadow-sm" readonly>Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                            <input type="hidden" id="subtotal" name="subtotal" value="{{ $subtotal }}">
                        </div>
                        
                        <div class="col-md-4">
                            <label for="ppn" class="form-label">PPN (%)</label>
                            <input type="text" class="form-control shadow-sm" id="ppn" name="ppn" value="{{ $ppn }}%" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="grand_total_include_ppn" class="form-label">Total Keseluruhan (Termasuk PPN)</label>
                            <input type="text" class="form-control shadow-sm" id="grand_total_include_ppn" name="grand_total_include_ppn" value="Rp {{ number_format($grandTotalIncludePPN, 0, ',', '.') }}" readonly>
                        </div>
                    </div>

                    <!-- DP and Installments -->
                    <h5 class="mt-4 mb-3">Pembayaran</h5>
                    <div class="mb-3">
                        <label for="dp" class="form-label">DP (%)</label>
                        <input type="number" class="form-control shadow-sm @error('dp') is-invalid @enderror" id="dp" name="dp" step="0.01" max="100" placeholder="Masukkan persentase DP (0-100)">
                        @error('dp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Catatan</label>
                        <textarea 
                            class="form-control shadow-sm @error('remarks') is-invalid @enderror" 
                            id="remarks" 
                            name="remarks" 
                            rows="3" 
                            placeholder="Masukkan catatan untuk pembayaran"
                            required
                        >Pembayaran wajib dilakukan sebanyak 2 kali, yaitu: 
                    1. Pembayaran DP sesuai ketentuan. 
                    2. Pembayaran sisa sesuai grand total setelah DP.</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.proformainvoice.index', $purchaseOrder->quotation_id) }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="fas fa-save"></i> Simpan Proforma Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
