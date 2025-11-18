<!-- ================= RELATED ARTICLES ================= -->
<section class="relative w-full min-h-screen bg-cover bg-center overflow-hidden flex items-center justify-center" style="background-color: #1E201E;">
  <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <h2 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white text-center mb-16">Related Article</h2>

    @if($articles && $articles->count())
      <div id="article-carousel" class="relative h-[500px] flex items-center justify-center">
        @foreach($articles as $index => $article)
          <div class="article-card absolute cursor-grab active:cursor-grabbing" 
               data-index="{{ $index }}" 
               data-url="{{ route('articles.show', $article->slug) }}"
               style="transition: transform 0.6s cubic-bezier(0.4,0,0.2,1), opacity 0.6s ease, z-index 0s;">
            <article class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden w-[380px] border border-white/20">
              @if($article->image && file_exists(public_path('images/' . $article->image)))
                <img src="{{ asset('images/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-56 object-cover pointer-events-none">
              @else
                <div class="w-full h-56 bg-gray-200 flex items-center justify-center text-gray-500">
                  No image
                </div>
              @endif
              <div class="p-6">
                <h4 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2">{{ $article->title }}</h4>
                <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ $article->excerpt }}</p>
                <span class="inline-block text-sm font-semibold text-[#7c8d34] hover:underline">Read more →</span>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <div class="flex items-center justify-center gap-4 mt-12">
        <button id="prev-article" class="px-6 py-3 bg-white/10 backdrop-blur-md border border-white/30 text-white rounded-full hover:bg-white/20 transition font-semibold">← Prev</button>
        <div id="article-indicator" class="flex gap-2">
          @foreach($articles as $i => $art)
            <span class="indicator-dot w-3 h-3 rounded-full bg-white/30 transition" data-dot="{{ $i }}"></span>
          @endforeach
        </div>
        <button id="next-article" class="px-6 py-3 bg-white/10 backdrop-blur-md border border-white/30 text-white rounded-full hover:bg-white/20 transition font-semibold">Next →</button>
      </div>
    @else
      <p class="text-white/70 text-center">Tidak ada artikel ditemukan.</p>
    @endif
  </div>
</section>
