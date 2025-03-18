@extends('layouts.distributor.master')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <!-- Header -->
            <h2 class="text-center mb-5" style="font-family: 'Poppins', sans-serif; color: #00796b; font-weight: 700;">
                Create Purchase Order
            </h2>
            <p class="text-center text-muted mb-4">
                Quotation #{{ $quotation->application_number }}
            </p>

            <!-- Accordion for Quotation Details -->
            <div class="accordion mb-5" id="quotationAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Quotation Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#quotationAccordion">
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
                                        <td>{{ $quotation->application_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date</strong></td>
                                        <td>{{ $quotation->created_at->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Amount</strong></td>
                                        <td>Rp {{ number_format($quotation->grand_total, 2, ',', '.') }}</td>
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
                                    @foreach ($quotation->products as $product)
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
                                            <td>{{ number_format($product->unit_price, 2) }}</td>
                                            <td>{{ number_format($product->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('distributor.purchaseorder.store', $quotation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- PO Number -->
                <div class="form-group mb-4">
                    <label for="po_number" class="form-label" style="font-weight: 600; color: #004d40;">PO Number</label>
                    <div class="input-group shadow-sm rounded">
                        <span class="input-group-text bg-light text-muted" id="basic-addon1">
                            <i class="fas fa-hashtag"></i>
                        </span>
                        <input type="text" class="form-control" id="po_number" name="po_number" placeholder="Enter PO Number" required>
                    </div>
                </div>

                <!-- Upload PO File -->
                <div class="form-group mb-4">
                    <label for="file_path" class="form-label" style="font-weight: 600; color: #004d40;">Upload PO File</label>
                    <div class="custom-file">
                        <input type="file" class="form-control shadow-sm" id="file_path" name="file_path" accept=".pdf,.doc,.docx" required>
                        <small class="form-text text-muted mt-2">
                            Supported formats: <span class="fw-bold">PDF, DOC, DOCX</span>
                        </small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm rounded-pill px-5" style="background: #00796b; border: none;">
                        <i class="fas fa-paper-plane me-2"></i> Submit PO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
