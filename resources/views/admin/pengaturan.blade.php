@extends('admin.layout')

@section('title', 'Pengaturan Voting - E-Voting OSIS')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><i class="fas fa-cog me-2"></i>Pengaturan Voting</h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Pengaturan Utama</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaturan.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <!-- gunakan votingAktifManual untuk tombol on/off -->
                            <input class="form-check-input" type="checkbox" id="votingAktif" name="voting_aktif" 
                                {{ $votingAktifManual ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="votingAktif">
                                Aktifkan Voting Manual
                            </label>
                        </div>
                        <small class="text-muted">Jika dinonaktifkan, siswa tidak dapat melakukan voting secara manual</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Waktu Mulai Voting</label>
                                <input type="datetime-local" name="waktu_mulai" class="form-control" value="{{ $waktuMulai }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Waktu Selesai Voting</label>
                                <input type="datetime-local" name="waktu_selesai" class="form-control" value="{{ $waktuSelesai }}">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h5>
            </div>
            <div class="card-body">
                <h6>Status Voting:</h6>
                @if($votingAktifManual)
                    <span class="badge bg-success fs-5 mb-2">
                        <i class="fas fa-check-circle me-1"></i> AKTIF
                    </span>
                @else
                    <span class="badge bg-danger fs-5 mb-2">
                        <i class="fas fa-times-circle me-1"></i> TIDAK AKTIF
                    </span>
                @endif
                
                <hr>
                
                <h6>Jadwal:</h6>
                    <p class="mb-1">
                        <strong>Mulai:</strong>
                        {{ $waktuMulai ? \Carbon\Carbon::parse($waktuMulai)->format('d-m-Y H:i') : 'Belum diatur' }}
                    </p>

                    <p class="mb-0">
                        <strong>Selesai:</strong>
                        {{ $waktuSelesai ? \Carbon\Carbon::parse($waktuSelesai)->format('d-m-Y H:i') : 'Belum diatur' }}
                    </p>
                <hr>
                
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Catatan:</strong> Pastikan untuk mengaktifkan voting hanya pada saat pemilihan berlangsung.
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h5>
            </div>
            <div class="card-body">
                <p class="small">Mereset voting akan menghapus semua suara yang telah diberikan dan mengembalikan status memilih semua siswa.</p>
                <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#resetModal">
                    <i class="fas fa-redo me-2"></i>Reset Semua Voting
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reset Modal -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Reset Semua Voting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle fa-2x me-2"></i>
                    <strong>Peringatan! Tindakan ini tidak dapat dibatalkan.</strong>
                </div>
                <p>Mereset voting akan:</p>
                <ul>
                    <li>Menghapus semua suara yang telah diberikan</li>
                    <li>Mengembalikan status memilih semua siswa ke "Belum Memilih"</li>
                    <li>Menonaktifkan voting</li>
                </ul>
                <p class="fw-bold">Apakah Anda yakin ingin melanjutkan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.resetVoting') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Ya, Reset Voting</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection