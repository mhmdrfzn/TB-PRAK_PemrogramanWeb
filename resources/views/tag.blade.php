@extends('layouts.app')

@section('content')

    <div class="navbar-category border-top">
        <div class="container">
            <div class="d-flex">
                <a class="cat-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    Home
                </a>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <a class="cat-link" href="{{ route('categories.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div style="height: 50px;"></div>

    <div class="container mb-5">
        
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="fw-bold border-start border-5 border-danger ps-3">
                    Topik: <span class="text-danger">#{{ $tag->name }}</span>
                </h1>
                <p class="text-muted ms-4">Menampilkan {{ $articles->total() }} artikel dengan topik ini.</p>
            </div>
        </div>

        <div class="row">
            @forelse($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card news-card h-100">
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
            @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3"><i class="bi bi-search display-1 text-muted"></i></div>
                <h4 class="text-muted">Belum ada berita dengan tag #{{ $tag->name }}.</h4>
                <a href="/" class="btn btn-outline-danger rounded-pill mt-3">Kembali ke Home</a>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $articles->links() }}
        </div>

    </div>
@endsection