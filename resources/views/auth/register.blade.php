@extends('layouts.admin')

@section('content')
<style>
    .register-image {
        background: url('https://source.unsplash.com/random/1200x900/?computer,creative') no-repeat center center;
        background-size: cover;
        min-height: 100vh;
    }
    .register-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
    }
    .form-wrapper {
        width: 100%;
        max-width: 400px;
        padding: 20px;
    }
</style>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-lg-5 register-section">
            <div class="form-wrapper">
                <h2 class="fw-bold mb-2 text-danger">Buat Akun Baru</h2>
                <p class="text-muted mb-4">Bergabunglah menjadi penulis hebat.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap">
                        <label for="name">Nama Lengkap</label>
                        @error('name')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                         <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required placeholder="Username">
                         <label for="username">Username</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                        <label for="email">Alamat Email</label>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- 1. PASSWORD UTAMA --}}
                    <div class="position-relative mb-3">
                        <div class="form-floating">
                            <input id="password" type="password" class="form-control pe-5 @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password" placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                            id="togglePassword" style="cursor: pointer; z-index: 10;">
                            <i class="bi bi-eye text-muted fs-5" id="iconPassword"></i>
                        </span>
                    </div>

                    {{-- 2. KONFIRMASI PASSWORD --}}
                    <div class="position-relative mb-4">
                        <div class="form-floating">
                            <input id="password-confirm" type="password" class="form-control pe-5" 
                                name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            <label for="password-confirm">Ulangi Password</label>
                        </div>

                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                            id="toggleConfirm" style="cursor: pointer; z-index: 10;">
                            <i class="bi bi-eye text-muted fs-5" id="iconConfirm"></i>
                        </span>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-pill">DAFTAR SEKARANG</button>

                    <div class="text-center mt-4">
                        <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-danger fw-bold text-decoration-none">Masuk disini</a></small>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block register-image"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        function setupToggle(triggerId, inputId, iconId) {
            const trigger = document.querySelector(triggerId);
            const input = document.querySelector(inputId);
            const icon = document.querySelector(iconId);

            if (trigger && input && icon) {
                trigger.addEventListener('click', function () {
                    // Ubah tipe input
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);

                    // Ubah Ikon
                    if (type === 'text') {
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash'); // Mata dicoret (terbuka)
                        icon.classList.remove('text-muted');
                        icon.classList.add('text-primary'); // Opsional: Beri warna saat aktif
                    } else {
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye'); // Mata biasa (tertutup)
                        icon.classList.add('text-muted');
                        icon.classList.remove('text-primary');
                    }
                });
            }
        }

        // Jalankan fungsi
        setupToggle('#togglePassword', '#password', '#iconPassword');
        setupToggle('#toggleConfirm', '#password-confirm', '#iconConfirm');

    });
</script>
@endsection