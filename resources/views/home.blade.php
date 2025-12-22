@extends('layouts.app')

@section('content')

    <div class="navbar-category border-top">
        <div class="container">
            <div class="d-flex">
                <a class="cat-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    Home
                </a>
                @foreach($categories as $category)
                    <a class="cat-link" href="{{ route('categories.show', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div style="height: 50px;"></div>

    <div class="container mb-5">
        
        @if($hero)
        <div class="row mb-5">
            <div class="col-12">
                <div class="hero-card shadow-lg">
                    <a href="{{ route('articles.show', $hero->slug) }}">
                        @if($hero->image)
                            <img src="{{ asset('storage/' . $hero->image) }}" class="hero-img" alt="...">
                        @else
                            <img src="https://source.unsplash.com/1200x600?{{ $hero->category->name }}" class="hero-img" alt="...">
                        @endif

                        <div class="hero-overlay">
                            <span class="badge bg-danger mb-2">{{ $hero->category->name }}</span>
                            <h1 class="fw-bold display-5">{{ $hero->title }}</h1>
                            <p class="fs-5 d-none d-md-block">{{ Str::limit($hero->excerpt, 150) }}</p>
                            <div class="small opacity-75">
                                <i class="bi bi-person-fill"></i> {{ $hero->user->name }} &bull; {{ $hero->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold border-start border-4 border-danger ps-3">Berita Terbaru</h3>
            <a href="#" class="text-danger fw-bold small">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="row">
            @foreach($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card news-card">
                    <div class="position-relative">
                        <span class="badge bg-danger category-badge">{{ $article->category->name }}</span>
                        
                        <a href="{{ route('articles.show', $article->slug) }}">
                            @if($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}" class="news-img w-100" alt="...">
                            @else
                                <img src="https://source.unsplash.com/500x300?{{ $article->category->name }}" class="news-img w-100" alt="...">
                            @endif
                        </a>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-3">
                            <a href="{{ route('articles.show', $article->slug) }}" class="text-dark text-decoration-none stretched-link">
                                {{ Str::limit($article->title, 60) }}
                            </a>
                        </h5>
                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($article->excerpt, 80) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted fw-bold" style="font-size: 0.8rem">
                                <i class="bi bi-person"></i> {{ Str::limit($article->user->name, 10) }}
                            </small>
                            <small class="text-muted" style="font-size: 0.8rem">
                                <i class="bi bi-calendar3"></i> {{ $article->created_at->format('d M') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $articles->links() }}
        </div>

    </div>
@endsection