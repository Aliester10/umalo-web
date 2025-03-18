@extends('layouts.admin.master')

@section('content')

<div class="col-md-12">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h1 class="h4">Daftar Proforma Invoices untuk Quotation #{{ $quotation->quotation_number }}</h1>
            </div>
            <div class="card-body">
                <!-- List Proforma Invoices -->
                @foreach ($quotation->purchaseOrders as $po)
                    <h5 class="mt-4 d-flex justify-content-between align-items-center">
                        <span>Purchase Order #{{ $po->po_number }}</span>
                        @if ($po->proformaInvoices->isEmpty())
                            <a href="{{ route('admin.proformainvoice.create', $po->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Tambah Proforma Invoice
                            </a>
                        @endif
                    </h5>
                    @if ($po->proformaInvoices->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Belum ada Proforma Invoice untuk PO ini.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>PI Number</th>
                                        <th>PI Date</th>
                                        <th>Subtotal</th>
                                        <th>PPN</th>
                                        <th>Grand Total</th>
                                        <th>DP Dibayar</th>
                                        <th>Pelunasan</th>                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($po->proformaInvoices as $index => $pi)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pi->pi_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pi->pi_date)->format('d M Y') }}</td>
                                            <td>Rp {{ number_format($pi->subtotal, 2, ',', '.') }}</td>
                                            <td>{{ $pi->ppn }}%</td>
                                            <td>Rp {{ number_format($pi->grand_total_include_ppn, 2, ',', '.') }}</td>
                                            <td>Rp {{ number_format($pi->dp, 2, ',', '.') }}</td>
                                            <td>Rp {{ number_format($pi->grand_total_after_dp) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach

                <!-- List Payment Proofs -->
                <h3 class="mt-5">Bukti Pembayaran</h3>
                @if ($paymentProofs->isEmpty())
                    <div class="alert alert-warning">Belum ada bukti pembayaran yang masuk.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Distributor</th>
                                    <th>PI Number</th>
                                    <th>Tipe Pembayaran</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentProofs as $index => $proof)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $proof->proformaInvoice->purchaseOrder->user->name }}</td>
                                        <td>{{ $proof->proformaInvoice->pi_number }}</td>
                                        <td>{{ ucfirst($proof->payment_type) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $proof->status === 'accepted' ? 'success' : ($proof->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($proof->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $proof->remarks ?? '-' }}</td>
                                        <td>
                                            <a href="{{ url($proof->proof_file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-file-pdf"></i> Lihat Bukti
                                            </a>
                                            @if ($proof->status === 'pending')
                                                <form action="{{ route('admin.proformainvoice.paymentProof.update', $proof->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i> Terima
                                                    </button>
                                                </form>

                                                <!-- Rejection Button -->
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $proof->id }}">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>

                                                <!-- Rejection Modal -->
                                                <div class="modal fade" id="rejectModal{{ $proof->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $proof->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin.proformainvoice.paymentProof.update', $proof->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="rejected">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="rejectModalLabel{{ $proof->id }}">Tolak Bukti Pembayaran</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="adminRemarks{{ $proof->id }}" class="form-label">Alasan Penolakan</label>
                                                                        <textarea name="admin_remarks" id="adminRemarks{{ $proof->id }}" class="form-control" rows="3" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali 
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
