<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kompas KW - Portal Berita Modern</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        
        /* HEADER 1: LOGO & AKUN */
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

        .cat-link {
            display: inline-block;
            padding: 12px 18px;
            color: #555;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        .cat-link:hover, .cat-link.active {
            color: #dc3545;
            border-bottom: 3px solid #dc3545;
            background-color: #fdfdfd;
        }
        .page-link {
        color: #dc3545; /* Teks merah */
        border: 1px solid #dee2e6;
        padding: 10px 18px; /* Tombol lebih besar & enak diklik */
        font-weight: 600;
        margin: 0 3px; /* Jarak antar tombol */
        border-radius: 8px; /* Sudut membulat modern */
        }

        .page-link:hover {
            color: #b02a37;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        /* Tombol Aktif (Halaman yg sedang dibuka) */
        .page-item.active .page-link {
            z-index: 3;
            color: #fff; /* Teks putih */
            background-color: #dc3545; /* Background MERAH */
            border-color: #dc3545;
            box-shadow: 0 4px 6px rgba(220, 53, 69, 0.3); /* Efek bayangan */
        }

        /* Hilangkan fokus biru jelek saat diklik */
        .page-link:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
        .navbar-category::-webkit-scrollbar { height: 0px; background: transparent; }

        /* Card Berita & Hero (Dipakai di Home & Category) */
        .hero-card { border: none; overflow: hidden; border-radius: 15px; position: relative; }
        .hero-img { height: 500px; object-fit: cover; width: 100%; transition: transform 0.5s ease; }
        .hero-card:hover .hero-img { transform: scale(1.05); }
        .hero-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(0,0,0,0)); padding: 20px; padding-top: 100px; color: white; }
        
        .news-card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: all 0.3s ease; height: 100%; overflow: hidden; background: white; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .news-img { height: 220px; object-fit: cover; }
        .category-badge { position: absolute; top: 15px; left: 15px; font-size: 0.8rem; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        
        a { text-decoration: none; color: inherit; }
        a:hover { color: #dc3545; }
    </style>
</head>
<body>

    @if (!in_array(Route::currentRouteName(), ['dashboard', 'dashboard.create', 'dashboard.edit'])) 
    <nav class="navbar-main">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold fs-3 text-danger" href="/">
                <i class="bi bi-newspaper me-2"></i>THE ARTICLE
            </a>

            <div class="d-flex align-items-center">
                @guest
                    <div class="dropdown">
                        <button class="btn btn-outline-dark rounded-pill px-4 fw-bold dropdown-toggle" type="button" id="guestMenu" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> Akun
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2 text-danger"></i> Login</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2" href="{{ route('register') }}"><i class="bi bi-person-plus me-2 text-danger"></i> Register</a></li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('dashboard.create') }}" class="btn btn-danger btn-sm rounded-pill px-3 me-3 d-none d-md-block">
                        <i class="bi bi-pencil-square me-1"></i> Tulis Berita
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle rounded-pill px-3 border" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ Str::limit(Auth::user()->name, 10) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-danger mb-3">THE ARTICLE</h5>
                    <p class="small text-secondary">Portal berita terpercaya untuk tugas besar Laravel Anda.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Kategori</h5>
                    <ul class="list-unstyled text-secondary small">
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <li class="mb-1"><a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                        @else
                           <li><a href="/">Home</a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <p class="small text-secondary">Gedung Kampus Tercinta<br>Jl. Koding No. 1</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small text-secondary">
                &copy; 2025 Project Laravel Tugas Besar.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>