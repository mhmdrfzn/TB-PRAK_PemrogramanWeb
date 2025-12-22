@extends('layouts.admin')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Edit Berita</h3>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('dashboard.update', $article->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Judul Artikel</label>
                            <input type="text" name="title" class="form-control form-control-lg fw-bold" value="{{ $article->title }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Kategori</label>
                                <select class="form-select" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Status</label>
                                <select class="form-select border-danger text-danger fw-bold" name="is_published">
                                    <option value="0" {{ $article->is_published == 0 ? 'selected' : '' }}>Draft</option>
                                    <option value="1" {{ $article->is_published == 1 ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Topik (Tags)</label>
                                <select class="form-select select2-multiple" name="tags[]" multiple="multiple">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}" 
                                            {{ $article->tags->pluck('name')->contains($tag->name) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Ketik lalu tekan Enter untuk menambahkan tag baru.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Gambar Utama</label>
                            <div class="d-flex align-items-center gap-3">
                                @if($article->image)
                                    <img id="imgPreview" src="{{ asset('storage/' . $article->image) }}" class="rounded-3 object-fit-cover" style="width: 100px; height: 80px;">
                                @else
                                    <img id="imgPreview" src="#" class="d-none rounded-3 object-fit-cover" style="width: 100px; height: 80px;">
                                @endif
                                
                                <div class="flex-grow-1">
                                    <input class="form-control" type="file" name="image" id="imageInput" onchange="previewImage()">
                                    <small class="text-muted d-block mt-2">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-muted small text-uppercase">Konten Berita</label>
                            <textarea class="form-control" name="body" rows="15" required style="resize: none;">{{ $article->body }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 w-100 fw-bold">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#imageInput');
        const imgPreview = document.querySelector('#imgPreview');

        imgPreview.style.display = 'block';
        imgPreview.classList.remove('d-none');

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection