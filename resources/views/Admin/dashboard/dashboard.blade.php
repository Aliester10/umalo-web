@extends('layouts.admin.master')

@section('content')

<div class="row g-3">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @foreach ($pendingDistributors as $distributor)
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center py-2">
                    <h6 class="mb-0">
                        <i class="fa fa-user-circle me-2"></i> Menunggu Verifikasi
                    </h6>
                    <small>
                        <i class="fa fa-calendar-alt me-1"></i> {{ $distributor->created_at->format('d-m-Y') }}
                    </small>
                </div>
                <div class="card-body py-2">
                    <p class="mb-1">
                        <strong>{{ $distributor->company_name }}</strong> dengan PIC 
                        <strong>{{ $distributor->name }}</strong>.
                    </p>
                    <p class="text-muted small mb-2">
                        Perusahaan ini mendaftar sebagai distributor. Segera lakukan verifikasi.
                    </p>
                    <div class="text-end">
                        <a href="{{ route('distributors.show', $distributor->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-eye me-1"></i> Cek Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>



<div class="row g-2 mb-2">
    @foreach ($ticketing as $ticket)
        @if ($ticket->status == 'Open')
            <div class="col-md-6">
                <div class="card border-warning shadow-sm" style="height: 100%;">
                    <div class="card-body py-2 d-flex flex-column">
                        <h6 class="card-title text-warning mb-2">
                            <i class="fa fa-exclamation-circle"></i> Tiket: Open
                        </h6>
                        <p class="card-text flex-grow-1 small mb-2">
                            Perusahaan <strong>{{ $ticket->user->company_name }}</strong> mengajukan tiket pada 
                            <strong>{{ $ticket->created_at->format('d-m-Y') }}</strong> untuk layanan 
                            <strong>{{ $ticket->service_type }}</strong>.
                        </p>
                        <a href="{{ route('admin.ticketing.index') }}" class="btn btn-warning btn-sm mt-auto w-100">Cek Tiket</a>
                    </div>
                </div>
            </div>
        @elseif ($ticket->status == 'Progress')
            <div class="col-md-6">
                <div class="card border-primary shadow-sm" style="height: 100%;">
                    <div class="card-body py-2 d-flex flex-column">
                        <h6 class="card-title text-primary mb-2">
                            <i class="fa fa-tasks"></i> Tiket: Progress
                        </h6>
                        <p class="card-text flex-grow-1 small mb-2">
                            Tiket untuk <strong>{{ $ticket->user->company_name }}</strong> (layanan: <strong>{{ $ticket->service_type }}</strong>) sedang dalam pengerjaan sejak 
                            <strong>{{ $ticket->action_start_date ? $ticket->action_start_date->format('d-m-Y') : 'tanggal belum ditentukan' }}</strong>. Mohon segera selesaikan.
                        </p>
                        <a href="{{ route('admin.ticketing.index') }}" class="btn btn-primary btn-sm mt-auto w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>




    <div class="row">
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.banner.index') }}" style="text-decoration: none;">
                <div class="card card-stats card-round" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Slider</p>
                                    <h4 class="card-title">{{ $totalMembers }}</h4> <!-- Display the customer count -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.product.index') }}" style="text-decoration: none;">
                <div class="card card-stats card-round" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Produk</p>
                                    <h4 class="card-title">{{ $totalProducts }}</h4> <!-- Display the product count -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.faq.index') }}" style="text-decoration: none;">
                <div class="card card-stats card-round" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">FAQ</p>
                                    <h4 class="card-title">{{ $totalMonitoredProducts }}</h4> <!-- Display the FAQ count -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.activity.index') }}" style="text-decoration: none;">
                <div class="card card-stats card-round" style="cursor: pointer">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-tasks"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Aktivitas</p>
                                    <h4 class="card-title">{{ $totalActivities }}</h4> <!-- Display the activity count -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
    </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-lg mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Kunjungan Harian Website</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <canvas id="daily-visits-chart"></canvas>
                        </div>
                        <p class="text-muted">
                            Grafik ini menunjukkan jumlah total kunjungan per hari
                        </p>
                    </div>
                </div>
            </div>
    
            <div class="col-md-6">
                <div class="card shadow-lg mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Jumlah Member per Bulan</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <canvas id="monthly-members-chart"></canvas>
                        </div>
                        <p class="text-muted">
                            Grafik ini menunjukkan jumlah total member yang mendaftar per bulan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('daily-visits-chart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($dates),
                        datasets: [{
                            label: 'Jumlah Kunjungan (Harian)',
                            data: @json($visits),
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `Date: ${tooltipItem.label}, Visits: ${tooltipItem.raw}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Visits'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthly-members-chart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($allMonths),
                datasets: [
                    {
                        label: 'Jumlah Member',
                        data: @json($memberCounts),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2
                    },
                    {
                        label: 'Jumlah Distributor',
                        data: @json($distributorCounts),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Pengguna'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

    @endsection
