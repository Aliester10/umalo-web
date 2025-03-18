@extends('layouts.member.master')

@section('content')

    <div class="row justify-content-center">
        <div class="d-flex justify-content-end mb-1">
            <a href="{{ route('member.ticketing.create') }}" class="btn btn-transparent btn-create-ticket">
                <i class="fas fa-plus me-2"></i> Ajukan Tiket
            </a>
                   
            
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h1 class="h4 mb-0">Daftar Tiket</h1>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end gap-2">
                        <!-- Tombol Status -->
                        <a href="{{ route('member.ticketing.index') }}" class="btn btn-light btn-sm {{ request('status') == null ? 'active' : '' }}">
                            <i class="fas fa-layer-group"></i> All
                        </a>
                        <a href="{{ route('member.ticketing.index', ['status' => 'Open']) }}" class="btn btn-warning btn-sm text-white {{ request('status') == 'Open' ? 'active' : '' }}">
                            <i class="fas fa-door-open"></i> Open
                        </a>
                        <a href="{{ route('member.ticketing.index', ['status' => 'Progress']) }}" class="btn btn-primary btn-sm text-white {{ request('status') == 'Progress' ? 'active' : '' }}">
                            <i class="fas fa-spinner"></i> Progress
                        </a>
                        <a href="{{ route('member.ticketing.index', ['status' => 'Close']) }}" class="btn btn-success btn-sm text-white {{ request('status') == 'Close' ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i> Close
                        </a>
                        <a href="{{ route('member.ticketing.index', ['status' => 'Batal']) }}" class="btn btn-danger btn-sm text-white {{ request('status') == 'Batal' ? 'active' : '' }}">
                            <i class="fas fa-ban"></i> Batal
                        </a>
                    </div>
                </div>
                
                
                <div class="card-body">
                    @if($ticketing->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Anda belum memiliki tiket.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <th>No</th>
                                    <th>Jenis Layanan</th>
                                    <th>Keterangan Pengajuan</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Status</th>
                                    <th>Tgl Tindakan</th>
                                    <th>Tgl Selesai</th>
                                    <th>PIC</th>
                                    <th>Keterangan Tindakan</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach($ticketing as $index => $ticketings)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $ticketings->service_type }}</td>
                                            <td>{{ $ticketings->submission_description  }}</td>
                                            <td>{{ $ticketings->created_at }}</td>
                                            <td>{{ $ticketings->status }}</td>
                                            <td>{{ $ticketings->action_start_date }}</td>
                                            <td>{{ $ticketings->action_close_date }}</td>
                                            <td>{{ $ticketings->technician }}</td>
                                            <td>{{ $ticketings->action_description }}</td>
                                            <td>
                                                <div class="dropdown member-actions-dropdown" data-bs-display="static">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="memberActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu member-actions-menu dropdown-menu-end" aria-labelledby="memberActionsDropdown">
                                                        <!-- View Data -->
                                                        <li>
                                                            <a href="{{ route('member.ticketing.show', $ticketings->id) }}" class="dropdown-item">
                                                                <i class="fas fa-eye"></i> Lihat Data
                                                            </a>
                                                        </li>
                                            
                                                        <!-- Edit Data (Hanya jika status Open) -->
                                                        @if ($ticketings->status == 'Open')
                                                            <li>
                                                                <a href="{{ route('member.ticketing.edit', $ticketings->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-edit"></i> Edit Data
                                                                </a>
                                                            </li>
                                            
                                                            <!-- Cancel Data (Hanya jika status Open) -->
                                                            <li>
                                                                <form action="{{ route('member.ticketing.cancel', $ticketings->id) }}" method="POST" style="display:inline-block;">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to cancel this ticket?');">
                                                                        <i class="fas fa-ban"></i> Batal
                                                                    </button>
                                                                </form>
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
                                        @if ($ticketing->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $ticketing->previousPageUrl() }}" aria-label="Previous">Previous</a>
                                            </li>
                                        @endif
                            
                                        {{-- Tombol Halaman --}}
                                        @for ($page = 1; $page <= $ticketing->lastPage(); $page++)
                                            @if ($page == $ticketing->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $ticketing->url($page) }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endfor
                            
                                        {{-- Tombol Next --}}
                                        @if ($ticketing->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $ticketing->nextPageUrl() }}" aria-label="Next">Next</a>
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