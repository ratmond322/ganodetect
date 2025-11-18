@extends('layouts.guest')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
  <h1 class="text-3xl font-semibold mb-8">Artikel</h1>

  @if($articles->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($articles as $a)
        @include('components.article-card', ['article' => $a])
      @endforeach
    </div>

    <div class="mt-8">
      {{ $articles->links() }}
    </div>
  @else
    <p>Tidak ada artikel ditemukan.</p>
  @endif
</div>
@endsection
