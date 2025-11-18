@props(['article'])

<a href="{{ route('articles.show', $article->slug) }}" class="group block">
  <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow">
    <div class="w-full h-48 overflow-hidden">
      <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>
    <div class="p-6">
      <h4 class="font-semibold text-lg mb-2 text-gray-900">{{ $article->title }}</h4>
      <p class="text-sm text-gray-500">{{ $article->author }} — {{ $article->published_at ? $article->published_at->format('d M Y') : '' }}</p>
    </div>
  </article>
</a>
