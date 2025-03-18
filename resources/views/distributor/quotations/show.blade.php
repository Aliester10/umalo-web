@extends('layouts.distributor.master')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h1 class="h4 mb-0">Detail Quotation</h1>
            </div>
            <div class="card-body">
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
                            <span class="badge bg-{{ $quotation->status == 'approved' ? 'success' : ($quotation->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($quotation->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Topik</th>
                        <td>{{ $quotation->topic }}</td>
                    </tr>
                    <tr>
                        <th>Perusahaan Penerima</th>
                        <td>{{ $quotation->recipient_company }}</td>
                    </tr>
                    <tr>
                        <th>Kontak Penerima</th>
                        <td>{{ $quotation->recipient_contact_person }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Quotation</th>
                        <td>{{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d F Y') }}</td>
                    </tr>
                </table>

                <!-- Authorized Person Information -->
                <h5 class="mt-4">Informasi Pihak Umalo</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Penandatangan</th>
                        <td>{{ $quotation->authorized_person_name ?? 'Tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan Penandatangan</th>
                        <td>{{ $quotation->authorized_person_position ?? 'Tidak tersedia' }}</td>
                    </tr>
                </table>
                <!-- Product Information -->
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



                <h5 class="mt-4">Informasi Purchase Order</h5>
                @if ($quotation->purchaseOrders->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor PO</th>
                                <th>Status</th>
                                <th>File</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotation->purchaseOrders as $index => $po)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $po->po_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $po->status == 'approved' ? 'success' : ($po->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($po->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ asset($po->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file"></i> Lihat File
                                        </a>
                                    </td>
                                    <td>{{ $po->created_at->format('d F Y') }}</td>
                                    <td>
                                        @if ($po->status == 'rejected')
                                            <a href="{{ route('distributor.purchaseorder.create', $quotation->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-redo"></i> Ajukan Ulang
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak Ada Tindakan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Belum ada Purchase Order untuk Quotation ini.</p>
                @endif


                <!-- Proforma Invoices Section -->
                <h5 class="mt-4">Informasi Proforma Invoice</h5>
                @if ($quotation->purchaseOrders->flatMap->proformaInvoices->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor PI</th>
                                <th>Status</th>
                                <th>Grand Total</th>
                                <th>Tanggal</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotation->purchaseOrders->flatMap->proformaInvoices as $index => $pi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pi->pi_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pi->status === 'paid' ? 'success' : ($pi->status === 'partially_paid' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($pi->status) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($pi->grand_total_include_ppn, 2, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pi->pi_date)->format('d F Y') }}</td>
                                    <td>
                                        <a href="{{ asset($pi->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file"></i> Lihat File
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Belum ada Proforma Invoice untuk Quotation ini.</p>
                @endif

                <!-- Payment Proofs Section -->
                <h5 class="mt-4">Bukti Pembayaran</h5>
                @if ($quotation->purchaseOrders->flatMap->proformaInvoices->flatMap->paymentProofs->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor PI</th>
                                <th>Tipe Pembayaran</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotation->purchaseOrders->flatMap->proformaInvoices->flatMap->paymentProofs as $index => $proof)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $proof->proformaInvoice->pi_number }}</td>
                                    <td>{{ ucfirst($proof->payment_type) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $proof->status === 'accepted' ? 'success' : ($proof->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($proof->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $proof->remarks ?? '-' }}</td>
                                    <td>
                                        <a href="{{ asset($proof->proof_file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-pdf"></i> Lihat Bukti
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Belum ada bukti pembayaran untuk Quotation ini.</p>
                @endif

                <!-- Back Button and PDF Link -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    @if (!empty($quotation->pdf_path))
                    <a href="{{ asset($quotation->pdf_path) }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Lihat PDF
                    </a>
                    @endif
                    <!-- Back Button -->
                    <a href="{{ route('distributor.quotations.index') }}" class="btn btn-secondary">Kembali</a>                   
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
