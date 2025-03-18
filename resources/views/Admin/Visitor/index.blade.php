@extends('layouts.admin.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3>Daftar Pengunjung</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alamat IP</th>
                            <th>Browser</th>
                            <th>Dikunjungi pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitors as $visitor)
                            <tr>
                                <td>{{ $visitor->ip_address }}</td>
                                <td>{{ $visitor->browser }}</td>
                                <td>{{ $visitor->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-lg mt-4">
            <div class="card-body">
                <h4>Rangkuman Kunjungan (Harian)</h4>
                <canvas id="daily-visits-chart"></canvas>
            </div>
        </div>

        <div class="card shadow-lg mt-4">
            <div class="card-body">
                <h4>Rangkuman Kunjungan (Mingguan)</h4>
                <canvas id="weekly-visits-chart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Daily Visits Chart
            const dailyCtx = document.getElementById('daily-visits-chart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Total Visits (Daily)',
                        data: @json($visits),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Weekly Visits Chart
            const weeklyCtx = document.getElementById('weekly-visits-chart').getContext('2d');
            new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: @json($weeks),
                    datasets: [{
                        label: 'Total Visits (Weekly)',
                        data: @json($weeklyVisits),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
