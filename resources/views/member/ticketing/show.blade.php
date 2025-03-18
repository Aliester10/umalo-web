@extends('layouts.member.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Detail Tiket</h4>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th>ID Tiket</th>
                    <td>{{ $ticket->id }}</td>
                </tr>
                <tr>
                    <th>Jenis Layanan</th>
                    <td>{{ ucfirst($ticket->service_type) }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $ticket->submission_description }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($ticket->status) }}</td>
                </tr>
                <tr>
                    <th>Dokumen Pendukung Pengajuan</th>
                    <td>
                        @if ($ticket->supporting_document)
                            @php
                                $documents = json_decode($ticket->supporting_document, true); // Decode JSON menjadi array
                            @endphp
                            @if (is_array($documents) && count($documents) > 0)
                                @foreach ($documents as $document)
                                    <a href="{{ asset($document) }}" target="_blank" class="d-block">Lihat Dokumen {{ $loop->iteration }}</a>
                                @endforeach
                            @else
                                Tidak ada dokumen
                            @endif
                        @else
                            Tidak ada dokumen
                        @endif
                    </td>
                </tr>
                
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td>{{ $ticket->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Laporan Pihak <span class="text-success">{{ $umalo->company_name }}</span></th>
                    <td></td>
                </tr>
                <tr>
                    <th>PIC</th>
                    <td>{{ $ticket->technician }}</td>
                </tr>
                @if ($ticket->action_start_date)
                <tr>
                    <th>Mulai Pengerjaan</th>
                    <td>{{ $ticket->action_start_date->format('d-m-Y H:i') }}</td>
                </tr>
            @endif
            
            @if ($ticket->action_close_date)
                <tr>
                    <th>Berakhir Pengerjaan</th>
                    <td>{{ $ticket->action_close_date->format('d-m-Y H:i') }}</td>
                </tr>
            @endif
            
                <tr>
                    <th>Deskripsi Pengerjaan</th>
                    <td>{{ $ticket->action_description }}</td>
                </tr>
                <tr>
                    <th>Dokumen Pendukung Pengerjaan</th>
                    <td>
                        @if ($ticket->action_document)
                            @php
                                $actionDocuments = json_decode($ticket->action_document, true); // Decode JSON menjadi array
                            @endphp
                            @if (is_array($actionDocuments) && count($actionDocuments) > 0)
                                @foreach ($actionDocuments as $actionDocument)
                                    <a href="{{ asset($actionDocument) }}" target="_blank" class="d-block">Lihat Dokumen {{ $loop->iteration }}</a>
                                @endforeach
                            @else
                                Tidak ada dokumen
                            @endif
                        @else
                            Tidak ada dokumen
                        @endif
                    </td>
                </tr>
                @if ($ticket->service_type === 'Permintaan Data' && $ticket->status === 'Close')
                    <tr class="table-active">
                        <th>Data Permintaan</th>
                        <td>
                            @if ($ticket->requestData->isNotEmpty())
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    @foreach ($ticket->requestData as $request)
                                        <div class="col">
                                            <div class="card shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $request->document_name }}</h5>
                                                    <p class="card-text text-muted">Dokumen terkait permintaan data.</p>
                                                    <a href="{{ asset($request->document_path) }}" target="_blank" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-file-download"></i> Unduh Dokumen
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Tidak ada data permintaan.</p>
                            @endif
                        </td>
                        
                    </tr>
                @endif
            </table>
            <a href="{{ route('member.ticketing.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="#" class="btn btn-primary btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </a>

            
            <style>
                /* Media print settings */
                @media print {
                    /* Sembunyikan elemen sidebar */
                    .sidebar {
                        display: none;
                    }
            
                    /* Atur tata letak halaman menjadi landscape */
                    @page {
                        size: A4 landscape; /* Ukuran kertas A4 dan orientasi landscape */
                        margin: 1cm; /* Margins untuk cetak */
                    }
            
                    /* Cetak hanya halaman ganjil */
                    body:before {
                        content: "Printing Odd Pages Only"; /* Informasi pada cetakan */
                        display: none; /* Komentar ini menunjukkan bahwa JavaScript digunakan untuk pengaturan halaman ganjil */
                    }
            
                    /* Pastikan semua elemen pada body berada di area cetak */
                    body {
                        transform: scale(0.85); /* Pastikan penyesuaian */
                    }
                }
            </style>
            
        </div>
    </div>
</div>
@endsection
