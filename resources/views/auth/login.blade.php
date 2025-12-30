@extends('layouts.admin')

@section('content')
<style>
    /* Reset margin body agar tidak ada sisa putih di pinggir */
    body {
        margin: 0;
        overflow-x: hidden; /* Mencegah scroll horizontal */
    }

    /* Gambar Login Full Height */
    .login-image {
        background: url('https://source.unsplash.com/random/1200x900/?office,modern') no-repeat center center;
        background-size: cover;
        height: 100vh; /* Wajib 100% tinggi layar */
    }

    /* Area Form Login Full Height */
    .login-section {
        height: 100vh; /* Wajib 100% tinggi layar */
        background-color: #fff;
    }
</style>

<div class="container-fluid p-0">
    <div class="row g-0"> <div class="col-lg-7 d-none d-lg-block">
            <div class="login-image"></div>
        </div>

        <div class="col-lg-5 d-flex align-items-center justify-content-center login-section">
            
            <div class="w-100 px-4" style="max-width: 420px;">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-danger">Selamat Datang</h2>
                    <p class="text-muted">Masuk untuk mengelola berita Anda.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                        <label for="email">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="position-relative mb-3">
                        <div class="form-floating">
                            <input id="password" type="password" class="form-control pe-5 @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="current-password" placeholder="Password">
                            <label for="password">Password</label>
                            
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                            id="togglePassword" style="cursor: pointer; z-index: 10;">
                            <i class="bi bi-eye text-muted fs-5" id="iconPassword"></i>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-secondary" for="remember">Ingat Saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none small text-danger fw-bold" href="{{ route('password.request') }}">Lupa Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill shadow-sm">MASUK SEKARANG</button>

                    <div class="text-center mt-4">
                        <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-danger fw-bold text-decoration-none">Daftar disini</a></small>
                    </div>
                </form>

                <div class="text-center mt-5 text-muted small">
                    &copy; 2025 Project Laravel Tugas Besar
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const iconPassword = document.querySelector('#iconPassword');

        if (togglePassword && passwordInput && iconPassword) {
            togglePassword.addEventListener('click', function () {
                // 1. Toggle Tipe Input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // 2. Toggle Ikon
                if (type === 'text') {
                    iconPassword.classList.remove('bi-eye');
                    iconPassword.classList.add('bi-eye-slash'); // Mata terbuka/dicoret
                    iconPassword.classList.remove('text-muted');
                    iconPassword.classList.add('text-primary'); // Opsional: warna biru saat aktif
                } else {
                    iconPassword.classList.remove('bi-eye-slash');
                    iconPassword.classList.add('bi-eye'); // Mata tertutup
                    iconPassword.classList.add('text-muted');
                    iconPassword.classList.remove('text-primary');
                }
            });
        }
    });
</script>
@endsection