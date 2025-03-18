@extends('layouts.admin.master')

@section('content')

<div class="row justify-content-center">


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

    @if (session('notification'))
    <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        {{ session('notification') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    

    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h1 class="h4 mb-0">Daftar Purchase Orders untuk Quotation #{{ $quotation->quotation_number }}</h1>
                </div>
            </div>

            <div class="card-body">
                @if($quotation->purchaseOrders->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Belum ada Purchase Orders untuk Quotation ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>PO Number</th>
                                    <th>Status</th>
                                    <th>File</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotation->purchaseOrders as $index => $po)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $po->po_number }}</td>
                                        <td>{{ ucfirst($po->status) }}</td>
                                        <td>
                                            <a href="{{ asset($po->file_path) }}" target="_blank">Lihat File</a>
                                        </td>
                                        <td>{{ $po->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="dropdown member-actions-dropdown" data-bs-display="static">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="memberActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu member-actions-menu dropdown-menu-end" aria-labelledby="memberActionsDropdown">
                                                    <li>
                                                        <a href="{{ route('admin.purchaseorder.show', $po->id) }}" class="dropdown-item">
                                                            <i class="fas fa-eye"></i> Lihat Detail
                                                        </a>
                                                    </li>
                                                    @if ($po->status == 'pending')
                                                        <li>
                                                            <form action="{{ route('admin.purchaseorder.approve', $po->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menerima Purchase Order ini?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check"></i> Terima
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.purchaseorder.reject', $po->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak Purchase Order ini?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times"></i> Tolak
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif

                                                </ul>
                                                <style>
                                                    /* Dropdown khusus untuk Member Actions */
                                                .member-actions-dropdown .member-actions-menu {
                                                    position: fixed !important; /* Mengabaikan parent container */
                                                    z-index: 1050 !important;   /* Memastikan berada di atas elemen lain */
                                                    will-change: transform;    /* Memperbaiki posisi animasi jika ada */
                                                }
                                                /* Tambahkan spesifikasi jika perlu */
                                                .member-actions-dropdown .dropdown-toggle {
                                                    cursor: pointer;
                                                }
                                                </style>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Quotation
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
