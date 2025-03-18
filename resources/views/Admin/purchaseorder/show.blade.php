@extends('layouts.admin.master')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <!-- Header -->
            <h2 class="text-center mb-5" style="font-family: 'Poppins', sans-serif; color: #00796b; font-weight: 700;">
                Purchase Order Details
            </h2>
            <p class="text-center text-muted mb-4">
                PO Number: {{ $purchaseOrder->po_number }}
            </p>

            <!-- Purchase Order Details -->
            <div class="accordion mb-5" id="poAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Purchase Order Summary
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#poAccordion">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Field</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>PO Number</strong></td>
                                        <td>{{ $purchaseOrder->po_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>{{ ucfirst($purchaseOrder->status) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>File</strong></td>
                                        <td>
                                            <a href="{{ asset($purchaseOrder->file_path) }}" target="_blank">View File</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quotation Details -->
            <div class="accordion mb-5" id="quotationAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Quotation Details
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#quotationAccordion">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Field</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Application Number</strong></td>
                                        <td>{{ $purchaseOrder->quotation->application_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Quotation Number</strong></td>
                                        <td>{{ $purchaseOrder->quotation->quotation_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Amount</strong></td>
                                        <td>Rp {{ number_format($purchaseOrder->quotation->grand_total, 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <!-- Products Table -->
                            <h6 class="mt-4">Products Included</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseOrder->quotation->products as $product)
                                        <tr>
                                            <td>
                                                @if ($product->product->images->first())
                                                    <img src="{{ asset($product->product->images->first()->images) }}" alt="Product Image" width="50" height="50">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{{ $product->product->name ?? 'Unknown Product' }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>Rp {{ number_format($product->unit_price, 2, ',', '.') }}</td>
                                            <td>Rp {{ number_format($product->total_price, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection
