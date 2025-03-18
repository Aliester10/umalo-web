@extends('layouts.distributor.master')

@section('content')

<!-- Row Card No Padding -->
<div class="row row-card-no-pd">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-file-alt text-warning" style="font-size: 4rem;"></i> <!-- Request Quotation -->
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Quotation Request</p>
                            <h4 class="card-title">{{ $quotations->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-file-invoice text-success" style="font-size: 4rem;"></i> <!-- Purchase Orders -->
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Purchase Orders</p>
                            <h4 class="card-title">{{ $purchaseOrders->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-file-invoice-dollar text-danger" style="font-size: 4rem;"></i> <!-- Proforma Invoices -->
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Proforma Invoices</p>
                            <h4 class="card-title">{{ $proformaInvoices->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-comment-dots text-primary" style="font-size: 4rem;"></i> <!-- Messages -->
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Messages</p>
                            <h4 class="card-title">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="row g-3 mt-4">
    <div class="col-md-8">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-clipboard-list"></i> Informasi Aktivitas Anda
                </h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Quotation Requests
                        <span class="badge bg-warning">{{ $quotations->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Purchase Orders
                        <span class="badge bg-success">{{ $purchaseOrders->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Proforma Invoices
                        <span class="badge bg-danger">{{ $proformaInvoices->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Profile Picture Section -->
    <div class="col-md-4">
        <div class="card shadow-sm d-flex flex-column justify-content-center align-items-center">
            <div class="card-body text-center">
                <h5 class="card-title mb-3">
                    <i class="fas fa-user-circle"></i> Logo Perusahaan Anda
                </h5>
                <!-- Profile Picture -->
                <div class="position-relative d-flex justify-content-center align-items-center mb-3">
                    <img 
                        id="profileImagePreview" 
                        src="{{ auth()->user()->profile_photo ? asset(auth()->user()->profile_photo) : 'https://via.placeholder.com/150' }}" 
                        alt="Profile Picture" 
                        class="rounded-circle border shadow-sm" 
                        style="width: 250px; height: 250px; object-fit: cover; cursor: pointer;"
                        onclick="document.getElementById('profileImageUpload').click();">
                </div>
                <!-- Hidden File Input -->
                <form id="profileImageForm" action="{{ route('distributor.updateProfilePhoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" 
                           id="profileImageUpload" 
                           name="profile_photo" 
                           class="d-none" 
                           accept="image/*"
                           onchange="previewImage(event)">
                </form>
                <p class="text-muted">Klik gambar untuk mengganti logo perusahaan Anda.</p>
            </div>
        </div>
    </div>
</div>

<!-- Image Upload Preview Script -->
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileImagePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Submit form setelah gambar dipilih
        document.getElementById('profileImageForm').submit();
    }
}
</script>

@endsection
