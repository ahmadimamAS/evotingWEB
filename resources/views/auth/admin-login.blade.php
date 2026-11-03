@extends('layouts.app')

@section('title', 'Login Admin - E-Voting OSIS')

@section('content')
<style>
/* LOGIN BOX */
.login-box {
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    border: 2px solid #d4af37; /* emas */
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}

/* HOVER EFFECT */
.login-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(212, 175, 55, 0.3);
}

/* GARIS ANIMASI ATAS */
.login-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 4px;
    width: 0;
    background: linear-gradient(90deg, #d4af37, #f7e08a);
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
                    <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
                    <h3 class="fw-bold">Login Admin</h3>
                    <p class="text-muted">Masukkan username dan password</p>
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
                
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus>
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
                    <a href="{{ url('/') }}" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

