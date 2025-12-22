<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - Kompas KW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .article-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">THE ARTICLE</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="mb-3">
                    <h1 class="fw-bold mb-3">{{ $article->title }}</h1>
                    
                    <div class="d-flex justify-content-between text-muted border-bottom pb-3">
                        <div>
                            Oleh <span class="fw-bold text-dark">{{ $article->user->name }}</span> 
                            di kategori <span class="badge bg-danger">{{ $article->category->name }}</span>
                        </div>
                        <div>
                            {{ $article->created_at->isoFormat('D MMMM Y') }}
                        </div>
                    </div>
                </div>

                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" class="article-img rounded mb-4" alt="{{ $article->title }}">
                @else
                    <img src="https://source.unsplash.com/1200x600?{{ $article->category->name }}" class="article-img rounded mb-4" alt="{{ $article->title }}">
                @endif

                <article class="fs-5 lh-lg mb-5">
                    {!! $article->body !!}
                </article>

                <div class="mb-4">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="badge bg-secondary text-decoration-none me-1">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                <a href="/" class="text-decoration-none">&larr; Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
    <hr class="my-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-4">Komentar ({{ $article->comments->count() }})</h4>

            @auth
                <div class="card border-0 shadow-sm mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="me-3 text-center">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px;">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            
                            <form action="{{ route('comments.store') }}" method="POST" class="w-100">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                
                                <div class="mb-3">
                                    <textarea name="body" class="form-control" rows="3" placeholder="Tulis tanggapan Anda..." required></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-danger rounded-pill px-4 btn-sm fw-bold">Kirim Komentar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-light border text-center mb-5" role="alert">
                    Silakan <a href="{{ route('login') }}" class="fw-bold text-danger text-decoration-none">Login</a> untuk ikut berkomentar.
                </div>
            @endauth

            @forelse($article->comments()->latest()->get() as $comment)
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-light text-secondary border rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 45px; height: 45px;">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                    </div>
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold mb-0 me-2">{{ $comment->user->name }}</h6>
                            <small class="text-muted" style="font-size: 0.8rem">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        
                        <p class="text-secondary mb-1" style="font-size: 0.95rem;">
                            {{ $comment->body }}
                        </p>

                        @if(Auth::id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none" style="font-size: 0.8rem">Hapus</button>
                            </form>
                        @endif
                    </div>
                </div>
                <hr class="border-light">
            @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-chat-quote display-4 mb-3 d-block opacity-25"></i>
                    Belum ada komentar. Jadilah yang pertama!
                </div>
            @endforelse
            
        </div>
    </div>

    <footer class="bg-light text-center py-4 mt-5">
        <p>&copy; 2024 Kompas KW Project Laravel.</p>
    </footer>

</body>
</html>