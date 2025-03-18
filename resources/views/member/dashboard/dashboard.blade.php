@extends('layouts.member.master')

@section('content')


<!-- Row Card No Padding -->
<div class="row row-card-no-pd">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-box text-warning" style="font-size: 4rem;"></i> <!-- Produk Anda -->
                        </div> 
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Produk Anda</p>
                            <h4 class="card-title">{{ $userProducts->count() }}</h4>
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
                            <i class="fas fa-ticket-alt text-success" style="font-size: 4rem;"></i> <!-- Pengajuan Tiket Anda -->
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Pengajuan Tiket Anda</p>
                            <h4 class="card-title">{{ $allTickets }}</h4>
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
                            <i class="fas fa-list text-danger" style="font-size: 4rem;"></i> <!-- Aktivitas -->
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Aktivitas</p>
                            <h4 class="card-title">{{ $totalActivities }}</h4>
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
                            <i class="fas fa-comment-alt text-primary" style="font-size: 4rem;"></i> <!-- Masukan -->
                        </div>
                    </div>
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <p class="card-category">Masukan</p>
                            <h4 class="card-title">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    

  <div class="row g-3 mt-4">
    <div class="col-md-8">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-chart-pie"></i> Statistik Tiket Anda
                </h5>
                <div style="width: 100%; max-width: 400px; margin: 0 auto;">
                    <canvas id="ticketStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-md-4">
        <div class="card shadow-sm d-flex flex-column justify-content-center align-items-center">
            <div class="card-body text-center">
                <h5 class="card-title mb-3">
                    <i class="fas fa-user-circle"></i> Logo Perusahaan Anda
                </h5>
    
                <!-- Container for Profile Picture -->
                <div class="position-relative d-flex justify-content-center align-items-center mb-3">
                    <!-- Circular Profile Picture -->
                    <img 
                        id="profileImagePreview" 
                        src="{{ auth()->user()->profile_photo ? asset(auth()->user()->profile_photo) : 'https://via.placeholder.com/150' }}" 
                        alt="Profile Picture" 
                        class="rounded-circle border shadow-sm" 
                        style="width: 250px; height: 250px; object-fit: cover; cursor: pointer;"
                        onclick="document.getElementById('profileImageUpload').click();">
                </div>
                <!-- Hidden File Input -->
                <form id="profileImageForm" action="{{ route('member.updateProfilePhoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" 
                           id="profileImageUpload" 
                           name="profile_photo" 
                           class="d-none" 
                           accept="image/*"
                           onchange="previewImage(event)">
                </form>
                <p class="text-muted">Klik gambar untuk mengunggah foto profil baru.</p>
            </div>
        </div>
    </div>
</div>



    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ticketStatusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Open', 'Progress', 'Closed'],
                datasets: [{
                    data: [{{ $openTickets }}, {{ $progressTickets }}, {{ $closedTickets }}],
                    backgroundColor: ['#ffc107', '#007bff', '#28a745'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>

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
