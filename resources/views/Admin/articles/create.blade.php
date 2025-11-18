@extends('admin.layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card card-admin p-3">
      <h5>Create Article (stub)</h5>
      <form method="POST" action="{{ route('admin.articles.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input name="title" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Excerpt</label>
          <textarea name="excerpt" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Create</button>
      </form>
    </div>
  </div>
@endsection
