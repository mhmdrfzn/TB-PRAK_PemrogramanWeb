@extends('layouts.admin')

@section('content')
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Dashboard Saya</h2>
            <p class="text-muted mb-0">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
        <a href="{{ route('dashboard.create') }}" class="btn btn-danger rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Tulis Artikel Baru
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100 py-3">
                <div class="card-body">
                    <h1 class="fw-bold text-danger display-4 mb-0">{{ $stats['total_articles'] }}</h1>
                    <span class="text-muted small text-uppercase fw-bold">Total Artikel</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100 py-3">
                <div class="card-body">
                    <h1 class="fw-bold text-primary display-4 mb-0">{{ $stats['total_views'] }}</h1>
                    <span class="text-muted small text-uppercase fw-bold">Total Pembaca (Views)</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100 py-3">
                <div class="card-body">
                    <h1 class="fw-bold text-success display-4 mb-0">{{ $stats['published'] }}</h1>
                    <span class="text-muted small text-uppercase fw-bold">Tayang (Published)</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100 py-3">
                <div class="card-body">
                    <h1 class="fw-bold text-warning display-4 mb-0">{{ $stats['draft'] }}</h1>
                    <span class="text-muted small text-uppercase fw-bold">Draft (Belum Tayang)</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold">Daftar Artikel Terakhir</h5>
        </div>
        <div class="card-body p-0">
            @if($articles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Judul Artikel</th>
                            
                            <th>Penulis</th> 
                            
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 rounded overflow-hidden" style="width: 50px; height: 50px;">
                                        @if($article->image)
                                            <img src="{{ asset('storage/' . $article->image) }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <img src="https://source.unsplash.com/100x100?{{ $article->category->name }}" class="w-100 h-100 object-fit-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ Str::limit($article->title, 40) }}</div>
                                        <small class="text-muted">{{ $article->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light border rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px;">
                                        <i class="bi bi-person text-secondary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark small">{{ $article->user->name }}</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">{{ $article->user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border border-secondary rounded-pill fw-normal">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td>
                                @if($article->is_published)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> Tayang
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 rounded-pill">
                                        <i class="bi bi-clock-fill me-1"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-secondary">
                                    <i class="bi bi-eye me-1"></i>{{ $article->views }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('dashboard.edit', $article->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                
                                <form action="{{ route('dashboard.destroy', $article->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-top">
                {{ $articles->links() }}
            </div>

            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="text-muted">Belum ada artikel</h4>
                    <p class="text-secondary">Yuk mulai menulis artikel pertamamu sekarang!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.form-delete');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const currentForm = this;
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data ini akan hilang selamanya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        currentForm.submit();
                    }
                });
            });
        });
    });
</script>
@endsection