@extends('layouts.app')

@section('title', 'Login Siswa - E-Voting OSIS')

@section('content')
<style>
/* LOGIN BOX SISWA */
.login-box {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    border: 2px solid #0d1b2a; /* biru tua */
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}

/* HOVER EFFECT */
.login-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(13, 27, 42, 0.3);
}

/* GARIS ANIMASI ATAS */
.login-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 4px;
    width: 0;
    background: linear-gradient(90deg, #0d1b2a, #1b3a6b);
    transition: 0.4s;
}

.login-box:hover::before {
    width: 100%;
}
</style> 
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="login-box">
                <div class="text-center mb-4">
                    <i class="fas fa-user-graduate fa-4x text-primary mb-3"></i>
                    <h3 class="fw-bold">Login Siswa</h3>
                    <p class="text-muted">Masukkan NIK dan password Anda</p>
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
                
                <form method="POST" action="{{ route('siswa.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" required autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="{{ route('siswa.register.form') }}" class="text-primary text-decoration-none">
                        <i class="fas fa-user-plus me-1"></i> Registrasi Siswa
                    </a>
                </div>

                <div class="text-center mt-2">
                    <a href="{{ url('/') }}" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

