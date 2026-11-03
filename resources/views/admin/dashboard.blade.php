@extends('admin.layout')

@section('title', 'Dashboard Admin - E-Voting OSIS')

@section('content')

<style>
/* ===== GLOBAL CARD ===== */
.card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

/* ===== STAT CARD ===== */
.stat-card {
    padding: 20px;
    border-radius: 16px;
    color: #fff;
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}

.stat-card:hover {
    transform: translateY(-6px);
}

/* GRADIENT WARNA */
.stat-card.blue {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
}
.stat-card.green {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
}
.stat-card.orange {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
}
.stat-card.red {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
}

/* ICON */
.stat-card i {
    opacity: 0.3;
}

/* ===== TABLE ===== */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background: #f8fafc;
}

.table th {
    font-weight: 600;
}

.table tbody tr:hover {
    background: #f1f5f9;
}

/* ===== IMAGE ===== */
.kandidat-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
}

/* ===== PROGRESS ===== */
.progress {
    border-radius: 20px;
    background: #e5e7eb;
}

.progress-bar {
    border-radius: 20px;
}

/* ===== HEADER ===== */
.card-header {
    border: none;
    border-radius: 16px 16px 0 0 !important;
}

/* ===== TITLE ===== */
h2 {
    font-weight: 700;
}
</style>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h2>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card blue">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Total Siswa</h6>
                    <h2 class="mb-0">{{ $totalSiswa }}</h2>
                </div>
                <i class="fas fa-users fa-3x"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Sudah Memilih</h6>
                    <h2 class="mb-0">{{ $totalMemilih }}</h2>
                </div>
                <i class="fas fa-check-circle fa-3x"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card orange">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Belum Memilih</h6>
                    <h2 class="mb-0">{{ $totalSiswa - $totalMemilih }}</h2>
                </div>
                <i class="fas fa-times-circle fa-3x"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card red">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Status Voting</h6>
                    <h5 class="mb-0">
                        @if($votingAktif)
                            <span class="badge bg-light text-success">AKTIF</span>
                        @else
                            <span class="badge bg-light text-danger">TIDAK AKTIF</span>
                        @endif
                    </h5>
                </div>
                <i class="fas fa-vote-yea fa-3x"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Results -->
<!-- Quick Results FULL WIDTH -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Perolehan Suara Cepat
                </h5>
            </div>
            <div class="card-body">
                @if($kandidats->count() > 0)
                    <canvas id="quickResultsChart" height="120"></canvas>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-user-slash fa-3x mb-3"></i>
                        <p>Belum ada kandidat</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Detail Stats -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Statistik Pemilihan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kandidat</th>
                                <th>Kelas</th>
                                <th>Jumlah Suara</th>
                                <th>Persentase</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalSuara = array_sum($hasilVoting);
                            @endphp

                            @forelse($kandidats as $index => $kandidat)
                            <tr>
                                <td>{{ $kandidat->no_urut }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($kandidat->foto)
                                            <img src="{{ asset('uploads/kandidat/' . $kandidat->foto) }}" class="kandidat-img me-2">
                                        @else
                                            <div class="kandidat-img bg-secondary d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        {{ $kandidat->nama }}
                                    </div>
                                </td>
                                <td>{{ $kandidat->kelas }}</td>
                                <td><strong>{{ $hasilVoting[$kandidat->id] ?? 0 }}</strong></td>
                                <td>
                                    @if($totalSuara > 0)
                                        {{ round((($hasilVoting[$kandidat->id] ?? 0) / $totalSuara) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{ $totalSuara > 0 ? (($hasilVoting[$kandidat->id] ?? 0) / $totalSuara) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-user-slash fa-2x mb-2"></i>
                                    <p>Belum ada kandidat yang terdaftar</p>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
@if($kandidats->count() > 0)
const ctx = document.getElementById('quickResultsChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($kandidats->pluck('nama')) !!},
        datasets: [{
            label: 'Jumlah Suara',
            data: {!! json_encode($kandidats->map(fn($k) => $hasilVoting[$k->id] ?? 0)) !!},
            backgroundColor: [
                '#2563eb',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6',
                '#ec4899'
            ],
            borderRadius: 8
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
@endif
</script>
@endsection