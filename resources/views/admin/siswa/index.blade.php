@extends('admin.layout')

@section('title', 'Data Siswa - E-Voting OSIS')

@section('content')

<style>
.card {
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}
.stat-card {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: #fff;
    padding: 20px;
    border-radius: 16px;
}
.badge-sudah { background:#dbeafe; padding:5px 10px; border-radius:20px;}
.badge-belum { background:#fee2e2; padding:5px 10px; border-radius:20px;}
</style>

<!-- HEADER -->
<div class="d-flex flex-wrap justify-content-between mb-3 gap-2">

    <!-- IMPORT -->
    <form action="/import-siswa" method="POST" enctype="multipart/form-data" class="d-flex">
        @csrf
        <input type="file" name="file" class="form-control me-2" required>
        <button class="btn btn-success">Import</button>
    </form>

    <div class="d-flex gap-2">
        <!-- TAMBAH -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            + Tambah
        </button>

        <!-- HAPUS -->
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusFilterModal">
            Hapus Data
        </button>
    </div>
</div>

<!-- STAT -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Total</h6>
            <h2>{{ $siswas->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Sudah</h6>
            <h2>{{ $siswas->where('status_memilih', true)->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h6>Belum</h6>
            <h2>{{ $siswas->where('status_memilih', false)->count() }}</h2>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswas as $i => $siswa)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $siswa->nik }}</td>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->kelas }}</td>
                    <td>
                        @if($siswa->status_memilih)
                            <span class="badge-sudah">Sudah</span>
                        @else
                            <span class="badge-belum">Belum</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn"
                            data-id="{{ $siswa->id }}"
                            data-nik="{{ $siswa->nik }}"
                            data-nama="{{ $siswa->nama }}"
                            data-kelas="{{ $siswa->kelas }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal">Edit</button>

                        <button class="btn btn-info btn-sm resetBtn"
                            data-id="{{ $siswa->id }}"
                            data-nama="{{ $siswa->nama }}"
                            data-bs-toggle="modal"
                            data-bs-target="#resetModal">Reset</button>

                        <button class="btn btn-danger btn-sm hapusBtn"
                            data-id="{{ $siswa->id }}"
                            data-nama="{{ $siswa->nama }}"
                            data-bs-toggle="modal"
                            data-bs-target="#hapusModal">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ================= TAMBAH ================= -->
<div class="modal fade" id="tambahModal">
    <div class="modal-dialog">
        <form action="{{ route('admin.siswa.store') }}" method="POST">
            @csrf
            <div class="modal-content p-3">
                <h5>Tambah Siswa</h5>
                <input type="text" name="nik" class="form-control mb-2" placeholder="NIK" required>
                <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                <input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                <button class="btn btn-primary w-100">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= EDIT ================= -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-content p-3">
                <h5>Edit Siswa</h5>
                <input type="text" id="editNik" name="nik" class="form-control mb-2">
                <input type="text" id="editNama" name="nama" class="form-control mb-2">
                <input type="text" id="editKelas" name="kelas" class="form-control mb-2">
                <input type="password" name="password" class="form-control mb-2">
                <button class="btn btn-primary w-100">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- RESET -->
<div class="modal fade" id="resetModal">
    <div class="modal-dialog">
        <form method="POST" id="resetForm">
            @csrf
            <div class="modal-content p-3">
                <p id="resetText"></p>
                <button class="btn btn-info w-100">Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- HAPUS ITEM -->
<div class="modal fade" id="hapusModal">
    <div class="modal-dialog">
        <form method="POST" id="hapusForm">
            @csrf
            @method('DELETE')
            <div class="modal-content p-3">
                <p id="hapusText"></p>
                <button class="btn btn-danger w-100">Hapus</button>
            </div>
        </form>
    </div>
</div>

<!-- HAPUS FILTER -->
<div class="modal fade" id="hapusFilterModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">

            <form action="/admin/siswa/hapus-kelas" method="POST" class="mb-2">
                @csrf
                <input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas">
                <button class="btn btn-warning w-100">Hapus per Kelas</button>
            </form>

            <form action="/admin/siswa/hapus-nama" method="POST" class="mb-2">
                @csrf
                <input type="text" name="nama" class="form-control mb-2" placeholder="Nama">
                <button class="btn btn-warning w-100">Hapus per Nama</button>
            </form>

            <form action="/admin/siswa/hapus-semua" method="POST"
                onsubmit="return confirm('Yakin hapus semua?')">
                @csrf
                <button class="btn btn-danger w-100">Hapus Semua</button>
            </form>

        </div>
    </div>
</div>

<!-- JS -->
<script>
document.querySelectorAll('.editBtn').forEach(btn=>{
    btn.onclick=()=>{
        editForm.action=`/admin/siswa/${btn.dataset.id}`;
        editNik.value=btn.dataset.nik;
        editNama.value=btn.dataset.nama;
        editKelas.value=btn.dataset.kelas;
    }
});

document.querySelectorAll('.resetBtn').forEach(btn=>{
    btn.onclick=()=>{
        resetForm.action=`/admin/siswa/reset/${btn.dataset.id}`;
        resetText.innerText="Reset "+btn.dataset.nama+" ?";
    }
});

document.querySelectorAll('.hapusBtn').forEach(btn=>{
    btn.onclick=()=>{
        hapusForm.action=`/admin/siswa/${btn.dataset.id}`;
        hapusText.innerText="Hapus "+btn.dataset.nama+" ?";
    }
});
</script>

@endsection