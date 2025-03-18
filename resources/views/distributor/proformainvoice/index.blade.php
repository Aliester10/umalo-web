@extends('layouts.distributor.master')

@section('content')

<div class="row justify-content-center">

    <!-- Flash Messages -->
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

    <!-- Main Table -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h1 class="h4 mb-0">Daftar Proforma Invoices</h1>
                </div>
            </div>

            <div class="card-body">
                @if($proformaInvoices->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Anda belum memiliki Proforma Invoices.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>PI Number</th>
                                    <th>Purchase Order</th>
                                    <th>Grand Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proformaInvoices as $index => $invoice)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $invoice->pi_number }}</td>
                                        <td>{{ $invoice->purchaseOrder->po_number ?? 'N/A' }}</td>
                                        <td>Rp {{ number_format($invoice->grand_total_include_ppn, 2, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown member-actions-dropdown" data-bs-display="static">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="memberActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu member-actions-menu dropdown-menu-end" aria-labelledby="memberActionsDropdown">
                                                    <!-- View Invoice -->
                                                    <li>
                                                        <a href="{{ asset($invoice->file_path) }}" target="_blank" class="dropdown-item">
                                                            <i class="fas fa-file-pdf"></i> Lihat PDF
                                                        </a>
                                                    </li>
                                                    <li>
                                                        @if (!$invoice->paymentProofs->contains('status', 'pending'))
                                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#paymentProofModal{{ $invoice->id }}">
                                                                <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                                                            </button>
                                                        @endif
                                                    </li>
                                                    
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewProofsModal{{ $invoice->id }}">
                                                            <i class="fas fa-eye"></i> Lihat Bukti Pembayaran
                                                        </button>
                                                    </li>
                                                    <!-- Additional Actions if Needed -->
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <style>
                                        .member-actions-dropdown .member-actions-menu {
                                            position: fixed !important;
                                            z-index: 1050 !important;
                                            will-change: transform;
                                        }
                                    </style>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('distributor.quotations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali 
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="paymentProofModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="paymentProofModalLabel{{ $invoice->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('distributor.proforma.submitPaymentProof', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentProofModalLabel{{ $invoice->id }}">Upload Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        // Check if DP is paid and accepted
                        $dpAccepted = $invoice->paymentProofs->where('payment_type', 'dp')->where('status', 'accepted')->isNotEmpty();
                    @endphp

                    @if (!$dpAccepted)
                        <div class="alert alert-warning">
                            Anda harus membayar DP terlebih dahulu sebelum melanjutkan ke pelunasan.
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="paymentType{{ $invoice->id }}" class="form-label">Tipe Pembayaran</label>
                        <select name="payment_type" 
                                id="paymentType{{ $invoice->id }}" 
                                class="form-control payment-type" 
                                data-invoice-id="{{ $invoice->id }}" 
                                data-dp-amount="{{ $invoice->dp }}" 
                                data-remaining-amount="{{ $invoice->grand_total_after_dp }}" 
                                required>
                            <option value="">Pilih Tipe Pembayaran</option>
                            <option value="dp" {{ $dpAccepted ? 'disabled' : '' }}>Down Payment (DP)</option>
                            <option value="balance" {{ !$dpAccepted ? 'disabled' : '' }}>Pelunasan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount{{ $invoice->id }}" class="form-label">Jumlah yang Harus Dibayar</label>
                        <input type="text" id="amount{{ $invoice->id }}" class="form-control" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="proofFile{{ $invoice->id }}" class="form-label">Bukti Pembayaran</label>
                        <input type="file" name="proof_file_path" id="proofFile{{ $invoice->id }}" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="remarks{{ $invoice->id }}" class="form-label">Catatan</label>
                        <textarea name="remarks" id="remarks{{ $invoice->id }}" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div class="modal fade" id="viewProofsModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="viewProofsModalLabel{{ $invoice->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProofsModalLabel{{ $invoice->id }}">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($invoice->paymentProofs->isEmpty())
                    <div class="alert alert-warning">Belum ada bukti pembayaran yang dikirim.</div>
                @else
                    <ul class="list-group">
                        @foreach($invoice->paymentProofs as $proof)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Tipe Pembayaran:</strong> {{ ucfirst($proof->payment_type) }}<br>
                                    <strong>Status:</strong> {{ ucfirst($proof->status) }}<br>
                                    <strong>Catatan:</strong> {{ $proof->remarks ?? '-' }}
                                    
                                    @if ($proof->status === 'rejected')
                                        <br><strong>Alasan Penolakan:</strong> {{ $proof->admin_remarks ?? 'Tidak ada alasan diberikan.' }}
                                    @endif
                                </div>
                                <a href="{{ url($proof->proof_file_path) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fas fa-file-pdf"></i> Lihat
                                </a>
                            </li>
                        @endforeach

                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>






<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle payment type change
    document.querySelectorAll('.payment-type').forEach(function (select) {
        select.addEventListener('change', function () {
            const invoiceId = this.getAttribute('data-invoice-id');
            const paymentType = this.value;

            // Fetch DP and remaining balance amounts dynamically
            const dpAmount = parseFloat(this.dataset.dpAmount);
            const remainingAmount = parseFloat(this.dataset.remainingAmount);
            const amountField = document.getElementById(`amount${invoiceId}`);

            if (paymentType === 'dp') {
                amountField.value = `Rp ${dpAmount.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
            } else if (paymentType === 'balance') {
                amountField.value = `Rp ${remainingAmount.toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
            } else {
                amountField.value = '';
            }
        });
    });
});

</script>
@endsection
