@extends('layouts.admin.master')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h1 class="h4 mb-0">Daftar Tiket</h1>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end gap-2">
                        <!-- Tombol Status -->
                        <a href="{{ route('admin.ticketing.index') }}" class="btn btn-light btn-sm {{ request('status') == null ? 'active' : '' }}">
                            <i class="fas fa-layer-group"></i> All
                        </a>
                        <a href="{{ route('admin.ticketing.index', ['status' => 'Open']) }}" class="btn btn-warning btn-sm text-white {{ request('status') == 'Open' ? 'active' : '' }}">
                            <i class="fas fa-door-open"></i> Open
                        </a>
                        <a href="{{ route('admin.ticketing.index', ['status' => 'Progress']) }}" class="btn btn-primary btn-sm text-white {{ request('status') == 'Progress' ? 'active' : '' }}">
                            <i class="fas fa-spinner"></i> Progress
                        </a>
                        <a href="{{ route('admin.ticketing.index', ['status' => 'Close']) }}" class="btn btn-success btn-sm text-white {{ request('status') == 'Close' ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i> Close
                        </a>
                        <a href="{{ route('admin.ticketing.index', ['status' => 'Batal']) }}" class="btn btn-danger btn-sm text-white {{ request('status') == 'Batal' ? 'active' : '' }}">
                            <i class="fas fa-ban"></i> Batal
                        </a>
                    </div>
                </div>
                
                
                <div class="card-body">
                    @if($ticketing->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Belum ada Permintaan tiket.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <th>No</th>
                                    <th>Perusahaan</th>
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
                                            <td>
                                                {{ $ticketings->user->company_name }}
                                                @if (!$ticketings->is_viewed_admin)
                                                    <span class="badge bg-warning text-dark ms-2">Periksa tiket</span>
                                                @endif
                                            </td>
                                            <td>{{ $ticketings->service_type }}</td>
                                            <td>{{ $ticketings->submission_description  }}</td>
                                            <td>{{ $ticketings->created_at }}</td>
                                            <td>{{ $ticketings->status }}</td>
                                            <td>{{ $ticketings->action_start_date }}</td>
                                            <td>{{ $ticketings->action_close_date }}</td>
                                            <td>{{ $ticketings->technician }}</td>
                                            <td>{{ $ticketings->action_description }}</td>
                                            <td>
                                                <div class="dropdown admin-actions-dropdown" data-bs-display="static">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="adminActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu admin-actions-menu dropdown-menu-end" aria-labelledby="adminActionsDropdown">
                                                        <!-- View Data -->
                                                        <li>
                                                            <a href="#" 
                                                               class="dropdown-item"
                                                               data-bs-toggle="modal" 
                                                               data-bs-target="#modalShowTicket"
                                                               data-id="{{ $ticketings->id }}" 
                                                               data-user-id="{{ $ticketings->user_id }}"
                                                               data-service="{{ $ticketings->service_type }}" 
                                                               data-description="{{ $ticketings->submission_description }}" 
                                                               data-document="{{ $ticketings->supporting_document }}" 
                                                               data-status="{{ $ticketings->status }}" 
                                                               data-start-action-date="{{ $ticketings->action_start_date ? $ticketings->action_start_date->format('d-m-Y') : '-' }}" 
                                                               data-end-action-date="{{ $ticketings->action_close_date ? $ticketings->action_close_date->format('d-m-Y') : '-' }}" 
                                                               data-technician="{{ $ticketings->technician ?? '-' }}" 
                                                               data-action-description="{{ $ticketings->action_description ?? '-' }}" 
                                                               data-action-document="{{ $ticketings->action_document ?? '-' }}" 
                                                               data-date="{{ $ticketings->created_at->format('d-m-Y') }}">
                                                                <i class="fas fa-eye"></i> Lihat Data
                                                            </a>
                                                        </li>
                                                        @if ($ticketings->service_type === 'Permintaan Data' && $ticketings->status === 'Progress')
                                                            <li>
                                                                <a href="#" 
                                                                class="dropdown-item"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalRequestData"
                                                                data-id="{{ $ticketings->id }}">
                                                                 <i class="fas fa-database"></i> Kirim Data
                                                             </a>
                                                            </li>
                                                        @elseif ($ticketings->status === 'Open')
                                                            <li>
                                                                <a href="#" 
                                                                class="dropdown-item"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalSelectTechnician"
                                                                data-id="{{ $ticketings->id }}">
                                                                    <i class="fas fa-spinner"></i> Proses
                                                                </a>
                                                            </li>
                                                        @elseif ($ticketings->status === 'Progress')
                                                            <li>
                                                                <a href="#" 
                                                                class="dropdown-item"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalCloseTicket"
                                                                data-id="{{ $ticketings->id }}">
                                                                    <i class="fas fa-check"></i> Selesaikan
                                                                </a>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </td>
                                            
                                            
                                            <style>
                                                /* Dropdown khusus untuk admin Actions */
                                            .admin-actions-dropdown .admin-actions-menu {
                                                position: fixed !important; /* Mengabaikan parent container */
                                                z-index: 1050 !important;   /* Memastikan berada di atas elemen lain */
                                                will-change: transform;    /* Memperbaiki posisi animasi jika ada */
                                            }
                                            /* Tambahkan spesifikasi jika perlu */
                                            .admin-actions-dropdown .dropdown-toggle {
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


    <!-- Modal for Technician Selection -->
<div class="modal fade" id="modalSelectTechnician" tabindex="-1" aria-labelledby="modalSelectTechnicianLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="technicianForm" action="#" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="Progress">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSelectTechnicianLabel">Isi Nama Penanggung Jawab</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="technician" class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" class="form-control" name="technician" id="technician" placeholder="Masukkan nama teknisi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalSelectTechnician');
        const form = document.getElementById('technicianForm');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Tombol yang memicu modal
            const ticketId = button.getAttribute('data-id'); // Ambil ID tiket
            
            // Gunakan route() untuk menghasilkan URL dinamis
            const actionUrl = `{{ route('admin.ticketing.update-status', ':id') }}`.replace(':id', ticketId);
            form.setAttribute('action', actionUrl); // Set form action URL
        });
    });
</script>


<!-- Modal Kirim Data -->
<div class="modal fade" id="modalRequestData" tabindex="-1" aria-labelledby="modalRequestDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="sendDataForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRequestDataLabel">Kirim Data Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="document_name" class="form-label">Nama Dokumen</label>
                        <input type="text" name="document_name" id="document_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="document_path" class="form-label">Unggah Dokumen</label>
                        <input type="file" name="document_path[]" id="document_path" class="form-control" multiple required>
                        <small class="text-muted">Anda dapat mengunggah lebih dari satu file. Format: PDF, DOCX, XLSX (maks. 10 MB per file).</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="action_description" class="form-label">Deskripsi Tindakan</label>
                        <textarea name="action_description" id="action_description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="action_document" class="form-label">Unggah Dokumen Tindakan (Opsional)</label>
                        <input type="file" name="action_document[]" id="action_document" class="form-control" multiple>
                        <small class="text-muted">Format yang diizinkan: PDF, JPG, JPEG, PNG (maks. 10 MB per file)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const modalRequestData = document.getElementById('modalRequestData');
    const sendDataForm = document.getElementById('sendDataForm');

    modalRequestData.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Tombol yang memicu modal
        const ticketId = button.getAttribute('data-id'); // Ambil ID tiket

        // Perbarui form action dengan ID tiket
        sendDataForm.action = `/admin/ticketing/${ticketId}/send-data`;
    });
});

</script>







    <!-- Modal -->
    <div class="modal fade" id="modalShowTicket" tabindex="-1" aria-labelledby="modalShowTicketLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalShowTicketLabel">Detail Tiket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Informasi ID Pengguna -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">ID Pengguna:</label>
                        <p id="ticketUserId" class="text-dark border p-2 rounded bg-light"></p>
                    </div>
    
                    <!-- Informasi Jenis Layanan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Jenis Layanan:</label>
                        <p id="ticketService" class="text-dark border p-2 rounded bg-light"></p>
                    </div>
    
                    <!-- Keterangan Pengajuan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Keterangan Pengajuan:</label>
                        <p id="ticketDescription" class="text-dark border p-2 rounded bg-light"></p>
                    </div>
    
                    <!-- Dokumen Pendukung -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Dokumen Pendukung:</label>
                        <div id="ticketDocumentContainer" class="row g-2 border p-2 rounded bg-light">
                            <!-- Gambar akan ditampilkan di sini -->
                        </div>
                    </div>
    
                    <!-- Informasi Status -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Status:</label>
                        <p id="ticketStatus" class="text-dark border p-2 rounded bg-light"></p>
                    </div>
    
                    <!-- Tanggal Pengajuan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Tanggal Pengajuan:</label>
                        <p id="ticketDate" class="text-dark border p-2 rounded bg-light"></p>
                    </div>
    
                    <!-- Tanggal Tindakan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Tanggal Tindakan:</label>
                        <p id="ticketActionStartDate" class="text-dark border p-2 rounded bg-light"></p>
                    </div>
    
                    <!-- Tanggal Selsai Tindakan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Tanggal Selesai Tindakan:</label>
                        <p id="ticketActionEndDate" class="text-dark border p-2 rounded bg-light"></p>
                    </div>

                    <!-- Keterangan Tindakan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Keterangan Tindakan:</label>
                        <p id="ticketActionDescription" class="text-dark border p-2 rounded bg-light"></p>
                    </div>
    
                    <!-- Dokumen Tindakan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Dokumen Tindakan:</label>
                        <div id="ticketActionDocumentContainer" class="row g-2 border p-2 rounded bg-light">
                            <!-- Gambar akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
                </div>
            </div>
        </div>
    </div>
    

    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const modalShowTicket = document.getElementById('modalShowTicket');

    modalShowTicket.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Ambil data dari atribut
        const userId = button.getAttribute('data-user-id');
        const service = button.getAttribute('data-service');
        const description = button.getAttribute('data-description');
        let documentLinks = button.getAttribute('data-document'); // Berisi JSON array untuk dokumen pendukung
        let actionDocumentLinks = button.getAttribute('data-action-document'); // Berisi JSON array untuk dokumen tindakan
        const status = button.getAttribute('data-status');
        const actionstartDate = button.getAttribute('data-start-action-date');
        const actionendDate = button.getAttribute('data-end-action-date');
        const actionDescription = button.getAttribute('data-action-description');
        const date = button.getAttribute('data-date');
        const baseUrl = window.location.origin; // Ambil base URL

        // Isi data ke dalam modal
        modalShowTicket.querySelector('#ticketUserId').textContent = userId;
        modalShowTicket.querySelector('#ticketService').textContent = service;
        modalShowTicket.querySelector('#ticketDescription').textContent = description;
        modalShowTicket.querySelector('#ticketStatus').textContent = status;
        modalShowTicket.querySelector('#ticketDate').textContent = date;
        modalShowTicket.querySelector('#ticketActionStartDate').textContent = actionstartDate;
        modalShowTicket.querySelector('#ticketActionEndDate').textContent = actionendDate;
        modalShowTicket.querySelector('#ticketActionDescription').textContent = actionDescription;

        // Tampilkan dokumen pendukung
        const ticketDocumentContainer = modalShowTicket.querySelector('#ticketDocumentContainer');
        ticketDocumentContainer.innerHTML = ''; // Reset kontainer dokumen pendukung
        if (documentLinks) {
            try {
                const documentArray = JSON.parse(documentLinks); // Decode JSON array
                documentArray.forEach((link) => {
                    const fullLink = link.startsWith('http') ? link : `${baseUrl}/${link}`;
                    if (fullLink.match(/\.(jpg|jpeg|png|gif)$/i)) {
                        ticketDocumentContainer.innerHTML += `
                            <div class="col-6 col-md-4">
                                <img src="${fullLink}" alt="Dokumen Pendukung" class="img-fluid rounded shadow-sm">
                            </div>
                        `;
                    } else if (fullLink.endsWith('.pdf')) {
                        ticketDocumentContainer.innerHTML += `
                            <div class="col-12">
                                <a href="${fullLink}" target="_blank" class="btn btn-link d-block">Buka PDF</a>
                            </div>
                        `;
                    } else {
                        ticketDocumentContainer.innerHTML += `
                            <div class="col-12">
                                <p class="text-muted">Tipe file tidak dikenali: ${fullLink}</p>
                            </div>
                        `;
                    }
                });
            } catch (error) {
                ticketDocumentContainer.innerHTML = `<p class="text-danger">Error memuat dokumen pendukung</p>`;
            }
        } else {
            ticketDocumentContainer.innerHTML = `<p>Tidak ada dokumen</p>`;
        }

        // Tampilkan dokumen tindakan
        const ticketActionDocumentContainer = modalShowTicket.querySelector('#ticketActionDocumentContainer');
        ticketActionDocumentContainer.innerHTML = ''; // Reset kontainer dokumen tindakan
        if (actionDocumentLinks) {
            try {
                const actionDocumentArray = JSON.parse(actionDocumentLinks); // Decode JSON array
                actionDocumentArray.forEach((link) => {
                    const fullLink = link.startsWith('http') ? link : `${baseUrl}/${link}`;
                    if (fullLink.match(/\.(jpg|jpeg|png|gif)$/i)) {
                        ticketActionDocumentContainer.innerHTML += `
                            <div class="col-6 col-md-4">
                                <img src="${fullLink}" alt="Dokumen Tindakan" class="img-fluid rounded shadow-sm">
                            </div>
                        `;
                    } else if (fullLink.endsWith('.pdf')) {
                        ticketActionDocumentContainer.innerHTML += `
                            <div class="col-12">
                                <a href="${fullLink}" target="_blank" class="btn btn-link d-block">Buka PDF</a>
                            </div>
                        `;
                    } else {
                        ticketActionDocumentContainer.innerHTML += `
                            <div class="col-12">
                                <p class="text-muted">Tipe file tidak dikenali: ${fullLink}</p>
                            </div>
                        `;
                    }
                });
            } catch (error) {
                ticketActionDocumentContainer.innerHTML = `<p class="text-danger">Error memuat dokumen tindakan</p>`;
            }
        } else {
            ticketActionDocumentContainer.innerHTML = `<p>Tidak ada dokumen tindakan</p>`;
        }
    });
});

    </script>



<div class="modal fade" id="modalCloseTicket" tabindex="-1" aria-labelledby="modalCloseTicketLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="closeTicketForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCloseTicketLabel">Selesaikan Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="Close">
                    <div class="mb-3">
                        <label for="action_description" class="form-label">Keterangan Tindakan</label>
                        <textarea name="action_description" id="action_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="action_document" class="form-label">Dokumen Tindakan (Bisa lebih dari 1)</label>
                        <input type="file" name="action_document[]" id="action_document" class="form-control" multiple>
                        <small class="form-text text-muted mt-1">
                            <i class="fas fa-info-circle"></i> Untuk mengirim lebih dari satu dokumen, pastikan semua file memiliki jenis ekstensi yang sama. Contoh: jika memilih PDF, pastikan semua file adalah PDF. Gambar tidak dapat digabungkan dengan file PDF atau format lainnya.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalCloseTicket = document.getElementById('modalCloseTicket');
        const closeTicketForm = document.getElementById('closeTicketForm');

        modalCloseTicket.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-id');
            closeTicketForm.action = `/admin/ticketing/${ticketId}/update-status`;
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalTriggerLinks = document.querySelectorAll('[data-bs-target="#modalShowTicket"]');

        modalTriggerLinks.forEach(link => {
            link.addEventListener('click', function () {
                const ticketId = this.getAttribute('data-id');

                // Kirim permintaan AJAX untuk memperbarui is_viewed_admin
                fetch(`/admin/ticketing/${ticketId}/mark-as-viewed`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal memperbarui status tiket.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Status tiket berhasil diperbarui.');
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>



@endsection