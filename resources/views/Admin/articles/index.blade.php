@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
  
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-1" style="color: #10b981;">Kelola Artikel</h2>
      <p class="mb-0" style="color: #9ca3af;">Tambah, edit, atau hapus artikel</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-success">
      <i class="fas fa-plus me-2"></i>Tambah Artikel
    </a>
  </div>

  <!-- Articles Table -->
  <div class="card border-0 shadow-sm" style="background: #2d3a1f; border: 1px solid rgba(16,185,129,0.2) !important;">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="color: #e5e7eb;">
          <thead style="background-color: rgba(16,185,129,0.1); border-bottom: 2px solid rgba(16,185,129,0.3);">
            <tr>
              <th class="px-4 py-3">Gambar</th>
              <th class="py-3">Judul</th>
              <th class="py-3">Penulis</th>
              <th class="py-3">Tanggal</th>
              <th class="py-3 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($articles as $article)
              <tr>
                <td class="px-4">
                  @if($article->image)
                    <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image) }}" 
                         alt="{{ $article->title }}" 
                         class="rounded"
                         style="width: 60px; height: 60px; object-fit: cover;"
                         onerror="this.src='https://via.placeholder.com/60x60/10b981/ffffff?text=No+Image'">
                  @else
                    <div class="rounded d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981, #34d399);">
                      <i class="fas fa-image text-white"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <div class="fw-semibold">{{ Str::limit($article->title, 50) }}</div>
                  <small class="text-muted">{{ Str::limit($article->excerpt ?? $article->body, 60) }}</small>
                </td>
                <td>{{ $article->author ?? 'Tim Ganodetect' }}</td>
                <td>
                  <small class="text-muted">
                    @if($article->published_at)
                      {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}
                    @else
                      {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}
                    @endif
                  </small>
                </td>
                <td class="text-center">
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('articles.show', $article->slug) }}" 
                       class="btn btn-outline-secondary" 
                       target="_blank"
                       title="Lihat">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.articles.edit', $article) }}" 
                       class="btn btn-outline-primary"
                       title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger" title="Hapus">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                    <p class="mb-0">Belum ada artikel. <a href="{{ route('admin.articles.create') }}">Tambah artikel pertama</a></p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
function confirmDelete(articleTitle) {
  return confirm('Apakah Anda yakin ingin menghapus artikel "' + articleTitle + '"?');
}
</script>

<style>
  .btn-success {
    background: linear-gradient(135deg, #10b981, #34d399);
    border: none;
    font-weight: 600;
  }
  .btn-success:hover {
    background: linear-gradient(135deg, #059669, #10b981);
  }
  .table-hover tbody tr:hover {
    background-color: rgba(16,185,129,0.1) !important;
    transition: background-color 0.15s ease-in-out;
  }
  .table tbody tr {
    border-bottom: 1px solid rgba(16,185,129,0.1);
  }
  .table {
    table-layout: fixed;
    width: 100%;
  }
  .table td, .table th {
    vertical-align: middle;
  }
</style>
@endsection
