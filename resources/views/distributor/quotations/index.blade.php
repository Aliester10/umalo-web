@extends('layouts.distributor.master')

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


        <div class="d-flex justify-content-end mb-1">
            <a href="{{ route('distributor.quotations.create') }}" class="btn btn-transparent btn-create-ticket">
                <i class="fas fa-plus me-2"></i> Ajukan Quotation
            </a>
                   
            
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h1 class="h4 mb-0">Daftar Quotation</h1>
                    </div>
                </div>
                
                
                <div class="card-body">
                     @if($quotations->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Anda belum memiliki Quotation.
                        </div>
                    @else 
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <th>No</th>
                                    <th>Nomor Pengajuan</th>
                                    <th>Status</th>
                                    <th>Topik</th>
                                    <th>Recipient Company</th>
                                    <th>Notes</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Perubahan Terkhir oleh Umalo</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach($quotations as $index => $quotation)
                                        <tr>
                                            <td>{{ ($quotations->currentPage() - 1) * $quotations->perPage() + $loop->iteration }}</td>
                                            <td>{{ $quotation->application_number }}</td>
                                            <td>{{ $quotation->status }}</td>
                                            <td>{{ $quotation->topic }}</td>
                                            <td>{{ $quotation->recipient_company }}</td>
                                            <td>{{ $quotation->notes }}</td>
                                            <td>{{ $quotation->created_at }}</td>
                                            <td>{{ $quotation->updated_at }}</td>
                                            <td>
                                                <div class="dropdown member-actions-dropdown" data-bs-display="static">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="memberActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu member-actions-menu dropdown-menu-end" aria-labelledby="memberActionsDropdown">
                                                        <!-- View Data -->
                                                        <li>
                                                            <a href="{{ route('distributor.quotations.show', $quotation->id) }}" class="dropdown-item">
                                                                <i class="fas fa-eye"></i> Lihat Data
                                                            </a>
                                                        </li>
                                                        @if (!empty($quotation->pdf_path) && $quotation->status !== 'close')
                                                        <li>
                                                            <a href="{{ asset($quotation->pdf_path) }}" target="_blank" class="dropdown-item">
                                                                <i class="fas fa-file-pdf"></i> Lihat PDF
                                                            </a>
                                                        </li>
                                                        @endif

                                                        @if ($quotation->status == 'approved') <!-- Only show if status is approved -->
                                                        @php
                                                            // Check if a negotiation exists and if distributor_notes is filled
                                                            $negotiation = $quotation->negotiations()->latest()->first();
                                                            $hasDistributorNotes = $negotiation && !empty($negotiation->distributor_notes);
                                                        @endphp
                                                        <li>
                                                            @if ($negotiation && $negotiation->status === 'close')
                                                                <a href="{{ route('distributor.quotations.negotiation.show', $negotiation->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-eye"></i> Lihat Hasil Negosiasi
                                                                </a>
                                                            @elseif ($hasDistributorNotes)
                                                                <a href="{{ route('distributor.quotations.negotiation.show', $negotiation->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-eye"></i> Lihat Negosiasi
                                                                </a>
                                                            @else
                                                                <a href="{{ route('distributor.quotations.negotiation.create', $quotation->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-handshake"></i> Ajukan Negosiasi
                                                                </a>
                                                            @endif
                                                        </li>
                                                        
                                                        @php
                                                            // Check if there are any Purchase Orders
                                                            $hasPurchaseOrders = $quotation->purchaseOrders->isNotEmpty();
                                                        
                                                            // Check if there are any Purchase Orders with status 'rejected'
                                                            $hasRejectedPO = $quotation->purchaseOrders->where('status', 'rejected')->isNotEmpty();
                                                        
                                                            // Check if there are any Purchase Orders with status 'approved'
                                                            $hasApprovedPO = $quotation->purchaseOrders->where('status', 'approved')->isNotEmpty();
                                                        
                                                            // Check if there are any Proforma Invoices associated with this Quotation
                                                            $hasProformaInvoices = $quotation->purchaseOrders->flatMap(function ($po) {
                                                                return $po->proformaInvoices;
                                                            })->isNotEmpty();

                                                        @endphp
                                                        
                                                        @if (!$hasApprovedPO)
                                                            <li>
                                                                <a href="{{ route('distributor.purchaseorder.create', $quotation->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-file-invoice"></i> {{ $hasRejectedPO ? 'Ajukan Ulang Purchase Order' : 'Ajukan Purchase Order' }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    
                                                        @endif

                                                        @php
                                                            $hasProformaInvoices = $quotation->purchaseOrders->flatMap(function ($po) {
                                                                return $po->proformaInvoices;
                                                            })->isNotEmpty();
                                                        @endphp
                                                        
                                                        @if ($hasProformaInvoices && $quotation->status !== 'close')
                                                        <li>
                                                            <a href="{{ route('distributor.proformainvoice.index', $quotation->id) }}" class="dropdown-item">
                                                                <i class="fas fa-file-invoice"></i> Lihat Proforma Invoice
                                                            </a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                            
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        {{-- Tombol Previous --}}
                                        @if ($quotations->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $quotations->previousPageUrl() }}" aria-label="Previous">Previous</a>
                                            </li>
                                        @endif
                            
                                        {{-- Tombol Halaman --}}
                                        @for ($page = 1; $page <= $quotations->lastPage(); $page++)
                                            @if ($page == $quotations->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $quotations->url($page) }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endfor
                            
                                        {{-- Tombol Next --}}
                                        @if ($quotations->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $quotations->nextPageUrl() }}" aria-label="Next">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                      @endif
                  </div>
            </div>
        </div>
    </div>

@endsection