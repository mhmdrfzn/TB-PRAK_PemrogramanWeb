@extends('layouts.admin')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Tulis Berita Baru</h3>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('dashboard.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Judul Artikel</label>
                            <input type="text" name="title" class="form-control form-control-lg fw-bold" placeholder="Tulis judul yang menarik..." required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Kategori</label>
                                <select class="form-select" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Topik (Tags)</label>
                                <select class="form-select select2-multiple" name="tags[]" multiple="multiple">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}" {{ (collect(old('tags'))->contains($tag->name)) ? 'selected' : '' }}>
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
                                <img id="imgPreview" src="#" alt="Preview" class="d-none rounded-3 object-fit-cover" style="width: 100px; height: 80px;">
                                <input class="form-control" type="file" name="image" id="imageInput" onchange="previewImage()">
                            </div>
                            <small class="text-muted d-block mt-2">*Maksimal 2MB. Format JPG/PNG.</small>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-muted small text-uppercase">Konten Berita</label>
                            <textarea class="form-control" name="body" rows="15" placeholder="Mulai menulis ceritamu disini..." required style="resize: none;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 w-100 fw-bold">Terbitkan Berita</button>
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