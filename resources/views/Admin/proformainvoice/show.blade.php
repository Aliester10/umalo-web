@extends('layouts.Admin.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <div class="card-body">
            <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; color: #00796b;">Detail Proforma Invoice</h2>

            @foreach ($proformaInvoice as $invoice)
            <!-- Informasi Proforma Invoice -->
            <table class="table">
                <tr>
                    <th>PI Number</th>
                    <td>{{ $invoice->pi_number }}</td>
                </tr>
                <tr>
                    <th>PI Date</th>
                    <td>{{ \Carbon\Carbon::parse($invoice->pi_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>PO Number</th>
                    <td>{{ $invoice->purchaseOrder->po_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Distributor</th>
                    <td>{{ $invoice->purchaseOrder->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Subtotal</th>
                    <td>Rp{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                @if (!empty($invoice->purchaseOrder->quotation->discount) && $invoice->purchaseOrder->quotation->discount > 0)
                <tr>
                    <th>Discount</th>
                    <td>Rp{{ number_format($invoice->purchaseOrder->quotation->discount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <th>PPN</th>
                    <td>Rp{{ number_format($invoice->ppn, 2) }}</td>
                </tr>
                <tr>
                    <th>Grand Total</th>
                    <td>Rp{{ number_format($invoice->grand_total_include_ppn, 2) }}</td>
                </tr>
                <tr>
                    <th>DP</th>
                    <td>Rp{{ number_format($invoice->dp, 2) }}</td>
                </tr>
                <tr>
                    <th>Installments</th>
                    <td>{{ $invoice->installments ?? '-' }} kali pembayaran</td>
                </tr>
                <tr>
                    <th>Next Payment Amount</th>
                    <td>
                        @if (!empty($invoice->next_payment_amount))
                            Rp{{ number_format($invoice->next_payment_amount, 2) }}
                        @else
                            <span class="text-muted">Belum ada pembayaran berikutnya</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Payments Completed</th>
                    <td>{{ $invoice->payments_completed ?? 0 }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge 
                            @if ($invoice->status === 'paid') bg-success
                            @elseif ($invoice->status === 'partially_paid') bg-warning
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                </tr>
            </table>

            <h4 class="mt-4">Aksi</h4>
            <div class="d-flex flex-column gap-2">
                <!-- View & Download PDF -->
                <a href="{{ asset($invoice->file_path) }}" target="_blank" class="btn btn-info btn-sm rounded-pill shadow-sm">
                    <i class="fas fa-file-pdf"></i> View PDF
                </a>
                <a href="{{ asset($invoice->file_path) }}" download class="btn btn-secondary btn-sm rounded-pill shadow-sm">
                    <i class="fas fa-download"></i> Download PDF
                </a>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
