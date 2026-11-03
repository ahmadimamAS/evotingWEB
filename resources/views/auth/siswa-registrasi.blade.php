@extends('layouts.app')

@section('title', 'Registrasi Siswa - E-Voting OSIS')

@section('content')
<style>
/* REGISTRASI BOX SISWA */
.register-box {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    border: 2px solid #0d1b2a;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}
.register-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(13, 27, 42, 0.3);
}
.register-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 4px;
    width: 0;
    background: linear-gradient(90deg, #0d1b2a, #1b3a6b);
    transition: 0.4s;
}
.register-box:hover::before {
    width: 100%;
}
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="register-box">
                <div class="text-center mb-4">
                    <i class="fas fa-user-plus fa-4x text-primary mb-3"></i>
                    <h3 class="fw-bold">Registrasi Siswa</h3>
                    <p class="text-muted">Daftar mandiri dan langsung bisa login</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('siswa.register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" required autofocus minlength="16" maxlength="16" pattern="\\d{16}" title="NIK harus 16 digit angka">
                        </div>
                        <div class="form-text">NIK harus 16 digit angka (cek validasi lokal).</div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-text">Minimal 6 karakter.</div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="fas fa-user-check me-2"></i>Daftar & Login
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('siswa.login.form') }}" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
