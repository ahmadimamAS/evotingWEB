@extends('admin.layout')

@section('title', 'Hasil Voting - E-Voting OSIS')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><i class="fas fa-chart-pie me-2"></i>Hasil Voting</h2>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <h6 class="mb-0">Total Suara Masuk</h6>
            <h2 class="mb-0">{{ $totalSuara }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <h6 class="mb-0">Jumlah Kandidat</h6>
            <h2 class="mb-0">{{ count($hasilVoting) }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card orange">
            <h6 class="mb-0">Partisipasi</h6>
            <h2 class="mb-0">
                @php
                    $totalSiswa = \App\Models\Siswa::count();
                    $persen = $totalSiswa > 0 ? round(($totalSuara / $totalSiswa) * 100, 1) : 0;
                @endphp
                {{ $persen }}%
            </h2>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4">
    <!-- Bar Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Grafik Batang</h5>
            </div>
            <div class="card-body">
                <canvas id="barChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Pie Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Grafik Pie</h5>
            </div>
            <div class="card-body">
                <canvas id="pieChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Results Table -->
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Detail Perolehan Suara</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No Urut</th>
                        <th>Kandidat</th>
                        <th>Kelas</th>
                        <th>Jumlah Suara</th>
                        <th>Persentase</th>
                        <th>Visualisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasilVoting as $data)
                        <tr>
                            <td><span class="badge bg-primary fs-6">{{ $data['kandidat']->no_urut }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($data['kandidat']->foto)
                                        <img src="{{ asset('uploads/kandidat/' . $data['kandidat']->foto) }}" class="kandidat-img me-2">
                                    @else
                                        <div class="kandidat-img bg-secondary d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                    <strong>{{ $data['kandidat']->nama }}</strong>
                                </div>
                            </td>
                            <td>{{ $data['kandidat']->kelas }}</td>
                            <td><strong class="fs-5">{{ $data['suara'] }}</strong></td>
                            <td><span class="badge bg-success fs-6">{{ $data['persen'] }}%</span></td>
                            <td style="width: 30%;">
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $data['persen'] }}%">
                                        {{ $data['persen'] }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-user-slash fa-2x mb-2"></i>
                                <p>Belum ada kandidat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-light">
                        <th colspan="3" class="text-end">TOTAL</th>
                        <th><strong>{{ $totalSuara }}</strong></th>
                        <th><strong>100%</strong></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Winner Announcement -->
@php
    $pemenang = collect($hasilVoting)->sortByDesc('suara')->first();
@endphp
@if($pemenang && $pemenang['suara'] > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-success text-white">
            <div class="card-body text-center py-4">
                <i class="fas fa-trophy fa-4x mb-3"></i>
                <h2 class="fw-bold">Pemenang Pemilihan</h2>
                <h3 class="mb-2">{{ $pemenang['kandidat']->nama }}</h3>
                <p class="mb-0">No. Urut {{ $pemenang['kandidat']->no_urut }} | {{ $pemenang['kandidat']->kelas }}</p>
                <h4 class="mt-2">{{ $pemenang['suara'] }} Suara ({{ $pemenang['persen'] }}%)</h4>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($hasilVoting)->pluck('kandidat.nama')) !!},
            datasets: [{
                label: 'Jumlah Suara',
                data: {!! json_encode(collect($hasilVoting)->pluck('suara')) !!},
                backgroundColor: [
                    '#2563eb',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6',
                    '#ec4899'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(collect($hasilVoting)->map(fn($d) => $d['kandidat']->nama . ' (' . $d['suara'] . ')')) !!},
            datasets: [{
                data: {!! json_encode(collect($hasilVoting)->pluck('suara')) !!},
                backgroundColor: [
                    '#2563eb',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6',
                    '#ec4899'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection

