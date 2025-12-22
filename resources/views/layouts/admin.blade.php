<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kompas Dashboard</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        .navbar-main {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            position: relative; 
            z-index: 1050;
        }

        /* HEADER 2: KATEGORI (Sticky) */
        .navbar-category {
            background: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            overflow-x: auto;
            white-space: nowrap;
        }

        /* Link Kategori */
        .cat-link {
            display: inline-block;
            padding: 12px 18px;
            color: #555;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none; /* Hapus garis bawah default */
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .cat-link:hover, .cat-link.active {
            color: #dc3545;
            border-bottom: 3px solid #dc3545;
            background-color: #fdfdfd;
        }

        /* Hilangkan scrollbar */
        .navbar-category::-webkit-scrollbar { height: 0px; background: transparent; }
    </style>
</head>
<body>
    <div id="app">
        @if (!in_array(Route::currentRouteName(), ['login', 'register', 'home', 'categories.show']))
        <nav class="navbar navbar-expand-md navbar-dark bg-danger shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-newspaper me-2"></i>ARTICLE DASHBOARD
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::is('dashboard') ? 'fw-bold' : '' }}" href="{{ route('dashboard') }}">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ url('/') }}" target="_blank">Lihat Website <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.8em"></i></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white {{ Route::is('categories.*') ? 'fw-bold' : '' }}" href="{{ route('categories.index') }}">
                                <i class="bi bi-tags me-1"></i> Kategori
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endif

        <main class="{{ in_array(Route::currentRouteName(), ['login', 'register']) ? '' : 'py-4' }}">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Cek apakah ada session 'success' dari Controller
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000 // Hilang otomatis dalam 2 detik
            });
        @endif

        // Cek apakah ada session 'error'
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Tunggu sampai halaman selesai dimuat
        $(document).ready(function() {
            // Cari semua input dengan class 'select2-multiple'
            $('.select2-multiple').select2({
                theme: 'bootstrap-5', // Pastikan tema bootstrap 5 dipakai
                width: '100%',        // Lebar penuh
                placeholder: 'Pilih atau ketik tag baru...',
                allowClear: true,     // Tombol hapus (x)
                tags: true,           // IZINKAN MENGETIK TAG BARU
                tokenSeparators: [','] // Tekan koma untuk enter
            });
        });

        // Script Alert Sukses/Gagal (Bawaan sebelumnya)
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", showConfirmButton: false, timer: 2000 });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", });
        @endif
    </script>


</body>
</html>