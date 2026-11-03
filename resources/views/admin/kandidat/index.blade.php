@extends('admin.layout')

@section('title', 'Data Kandidat - E-Voting OSIS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-user-tie me-2"></i>Data Kandidat</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="fas fa-plus me-2"></i>Tambah Kandidat
            </button>
        </div>
    </div>
</div>

<!-- Kandidat Grid -->
<div class="row">
    @forelse($kandidats as $kandidat)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                @if($kandidat->foto)
                    <img src="{{ asset('uploads/kandidat/' . $kandidat->foto) }}" class="card-img-top" alt="{{ $kandidat->nama }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-secondary" style="height: 200px;">
                        <i class="fas fa-user fa-4x text-white"></i>
                    </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary fs-6">No. {{ $kandidat->no_urut }}</span>
                    </div>
                    <h5 class="card-title fw-bold">{{ $kandidat->nama }}</h5>
                    <p class="text-muted mb-2"><i class="fas fa-graduation-cap me-1"></i> {{ $kandidat->kelas }}</p>
                    <hr>
                    <p class="card-text small">
                        <strong>Visi:</strong> {{ Str::limit($kandidat->visi, 100) }}
                    </p>
                    <p class="card-text small">
                        <strong>Misi:</strong> {{ Str::limit($kandidat->misi, 100) }}
                    </p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $kandidat->id }}">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger flex-grow-1" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $kandidat->id }}">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $kandidat->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kandidat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.kandidat.update', $kandidat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kandidat</label>
                                        <input type="text" name="nama" class="form-control" value="{{ $kandidat->nama }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kelas</label>
                                        <input type="text" name="kelas" class="form-control" value="{{ $kandidat->kelas }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Urut</label>
                                        <input type="number" name="no_urut" class="form-control" value="{{ $kandidat->no_urut }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Foto</label>
                                        <input type="file" name="foto" class="form-control" accept="image/*">
                                        <small class="text-muted">Kosongkan jika tidak diganti</small>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Visi</label>
                                <textarea name="visi" class="form-control" rows="3" required>{{ $kandidat->visi }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Misi</label>
                                <textarea name="misi" class="form-control" rows="4" required>{{ $kandidat->misi }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hapus Modal -->
        <div class="modal fade" id="hapusModal{{ $kandidat->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Kandidat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus kandidat <strong>{{ $kandidat->nama }}</strong>?</p>
                        <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('admin.kandidat.destroy', $kandidat->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada kandidat</h4>
            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="fas fa-plus me-2"></i>Tambah Kandidat Pertama
            </button>
        </div>
    @endforelse
</div>
<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kandidat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kandidat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Kandidat</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII IPA 1" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor Urut</label>
                                <input type="number" name="no_urut" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Visi</label>
                        <textarea name="visi" class="form-control" rows="3" placeholder="Tuliskan visi kandidat..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Misi</label>
                        <textarea name="misi" class="form-control" rows="4" placeholder="Tuliskan misi kandidat..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

