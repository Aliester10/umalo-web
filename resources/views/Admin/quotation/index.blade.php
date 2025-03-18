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
                                    <th>Tgl Pengajuan</th>
                                    <th>Status</th>
                                    <th>Topik</th>
                                    <th>Terms Conditions</th>
                                    <th>Recipient Company</th>
                                    <th>Notes</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach($quotations as $index => $quotation)
                                        <tr>
                                            <td>{{ ($quotations->currentPage() - 1) * $quotations->perPage() + $loop->iteration }}</td>                                            <td>{{ $quotation->application_number }}</td>
                                            <td>{{ $quotation->created_at }}</td>
                                            <td>{{ $quotation->status }}</td>
                                            <td>{{ $quotation->topic }}</td>
                                            <td>{{ $quotation->terms_conditions }}</td>
                                            <td>{{ $quotation->recipient_company }}</td>
                                            <td>{{ $quotation->notes }}</td>
                                            <td>
                                                <div class="dropdown member-actions-dropdown" data-bs-display="static">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="memberActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu member-actions-menu dropdown-menu-end" aria-labelledby="memberActionsDropdown">
                                                        <!-- View Data -->
                                                        <li>
                                                            <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="dropdown-item">
                                                                <i class="fas fa-eye"></i> Lihat Data
                                                            </a>
                                                        </li>
                                                        @if ($quotation->status !== 'rejected' && $quotation->status !== 'close')
                                                            <li>
                                                                <a href="{{ route('admin.quotations.edit', $quotation->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-edit"></i> Tanggapi
                                                                </a>
                                                            </li>
                                                        @endif

                                                        @php
                                                            $negotiation = $quotation->negotiations()->latest()->first();
                                                        @endphp
                                                        @if ($negotiation)
                                                            <li>
                                                                @if (empty($negotiation->admin_notes))
                                                                    <a href="{{ route('admin.quotations.negotiation.show', $negotiation->id) }}" class="dropdown-item">
                                                                        <i class="fas fa-handshake"></i> Tanggapi Negosiasi
                                                                    </a>
                                                                @elseif ($negotiation->status == 'close')
                                                                    <a href="{{ route('admin.quotations.negotiation.show', $negotiation->id) }}" class="dropdown-item">
                                                                        <i class="fas fa-eye"></i> Lihat Hasil Negosiasi
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('admin.quotations.negotiation.show', $negotiation->id) }}" class="dropdown-item">
                                                                        <i class="fas fa-eye"></i> Lihat Negosiasi
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        @endif
                                                        @if (!in_array($quotation->status, ['approved', 'rejected', 'close']))
                                                        <li>
                                                            <form action="{{ route('admin.quotations.reject', $quotation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak ajuan ini?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times-circle"></i> Tolak Ajuan
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    
                                                    

                                                        @if($quotation->status == 'approved')
                                                        <li>
                                                            <a href="{{ route('admin.purchaseorder.index', $quotation->id) }}" class="dropdown-item">
                                                                <i class="fas fa-file-invoice"></i> Lihat Purchase Order
                                                            </a>
                                                        </li>    
                                                        @endif

                                                        @if($quotation->status == 'approved')
                                                            <a href="{{ route('admin.proformainvoice.index', $quotation->id) }}" class="dropdown-item">
                                                                <i class="fas fa-file-invoice"></i> Lihat Proforma Invoice
                                                            </a>
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