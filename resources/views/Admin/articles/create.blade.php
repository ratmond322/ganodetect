@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
  
  <div class="mb-4">
    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary btn-sm mb-3" style="color: #9ca3af; border-color: #4b5563;">
      <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    <h2 class="fw-bold mb-1" style="color: #10b981;">Buat Artikel Baru</h2>
    <p class="mb-0" style="color: #9ca3af;">Isi formulir untuk menambahkan artikel</p>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card border-0 shadow-sm mb-4" style="background: #2d3a1f; border: 1px solid rgba(16,185,129,0.2) !important;">
          <div class="card-body p-4">
            
            <div class="mb-4">
              <label class="form-label fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul artikel" required>
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Slug URL <span class="text-muted small">(opsional)</span></label>
              <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="artikel-tentang-ganoderma">
              @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Penulis</label>
              <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', 'Tim Ganodetect') }}" placeholder="Nama penulis">
              @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Ringkasan</label>
              <textarea name="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Ringkasan singkat artikel">{{ old('excerpt') }}</textarea>
              @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Konten Artikel <span class="text-danger">*</span></label>
              <textarea name="body" rows="12" class="form-control @error('body') is-invalid @enderror" required>{{ old('body') }}</textarea>
              @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Gambar Thumbnail</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
              @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <small class="text-muted d-block mt-1">Format: JPG, PNG. Maks: 2MB</small>
              <div id="imagePreview" class="mt-3" style="display: none;">
                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Tanggal Publikasi</label>
              <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
              @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-success px-4"><i class="fas fa-save me-2"></i>Simpan Artikel</button>
          <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
        </div>

      </form>
    </div>

    <div class="col-lg-4">
      <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
        <div class="card-body">
          <h5 class="fw-bold mb-3" style="color: #166534;">💡 Tips Menulis Artikel</h5>
          <ul class="list-unstyled mb-0">
            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gunakan judul yang menarik</li>
            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Tambahkan gambar berkualitas</li>
            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Tulis konten informatif</li>
            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gunakan paragraf pendek</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
function previewImage(input) {
  const preview = document.getElementById('preview');
  const previewContainer = document.getElementById('imagePreview');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      previewContainer.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

<style>
  .btn-success { background: linear-gradient(135deg, #10b981, #34d399); border: none; font-weight: 600; }
  .btn-success:hover { background: linear-gradient(135deg, #059669, #10b981); }
  
  .form-label { color: #e5e7eb !important; }
  .form-control, .form-control-lg {
    background: #1a2312 !important;
    border-color: #4b5563 !important;
    color: #e5e7eb !important;
  }
  .form-control:focus {
    background: #1a2312 !important;
    border-color: #10b981 !important;
    color: #e5e7eb !important;
    box-shadow: 0 0 0 0.25rem rgba(16,185,129,0.25);
  }
  .form-control::placeholder {
    color: #6b7280 !important;
  }
</style>
@endsection
