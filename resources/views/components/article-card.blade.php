@props(['article'])

<a href="{{ route('articles.show', $article->slug) }}" class="group block">
  <article class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-green-500/20 transition-all duration-300 transform hover:scale-105">
    <div class="w-full h-48 overflow-hidden">
      <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
    </div>
    <div class="p-6">
      <h4 class="font-bold text-xl mb-3 text-white group-hover:text-yellow-300 transition-colors">{{ $article->title }}</h4>
      <p class="text-sm text-white/70">{{ $article->author }} — {{ $article->published_at ? $article->published_at->format('d M Y') : '' }}</p>
    </div>
  </article>
</a>
