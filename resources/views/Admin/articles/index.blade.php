@extends('admin.layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card card-admin p-3">
      <h5>Articles (stub)</h5>
      <ul class="list-group mt-3">
        @forelse($articles ?? [] as $a)
          <li class="list-group-item d-flex justify-content-between">
            <div>
              <div class="fw-bold">{{ $a->title }}</div>
              <div class="small text-muted">{{ Str::limit($a->excerpt, 80) }}</div>
            </div>
            <div class="small text-muted">{{ $a->created_at->format('d M Y') }}</div>
          </li>
        @empty
          <li class="list-group-item">No articles yet.</li>
        @endforelse
      </ul>
    </div>
  </div>
@endsection
