@extends('layouts.guest')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-[#2d3a1f] via-[#3a4a28] to-[#4a5a3a] -mt-24 md:-mt-28 overflow-hidden py-32 md:py-40">
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-40"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
    <span class="inline-block rounded-full px-4 py-2 bg-white/10 text-yellow-300 font-semibold tracking-wide backdrop-blur mb-6">
      Knowledge Base
    </span>
    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight">
      Artikel & Wawasan
    </h1>
    <p class="text-xl md:text-2xl text-white/80 max-w-3xl mx-auto">
      Pelajari lebih lanjut tentang teknologi deteksi penyakit kelapa sawit dan tips perkebunan modern
    </p>
  </div>
</section>

<!-- Articles Grid Section -->
<section class="relative bg-gradient-to-b from-[#1a2312] via-[#2d3a1f] to-[#1a2312] py-16 min-h-screen">
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-40"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    @if($articles->count())
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
          <a href="{{ route('articles.show', $article->slug) }}" class="group block">
            <article class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl overflow-hidden hover:shadow-2xl hover:shadow-green-500/20 transition-all duration-300 transform hover:scale-105">
              <div class="w-full h-48 overflow-hidden">
                @if($article->image)
                  <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : asset('storage/' . $article->image) }}" 
                       alt="{{ $article->title }}" 
                       class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                       onerror="this.onerror=null; this.src='{{ asset('images/placeholder-article.jpg') }}'; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-[#10b981] to-[#34d399] flex items-center justify-center\'><svg class=\'w-16 h-16 text-white/50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\'></path></svg></div>';">
                @else
                  <div class="w-full h-full bg-gradient-to-br from-[#10b981] to-[#34d399] flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </div>
                @endif
              </div>
              <div class="p-6">
                <h4 class="font-bold text-xl mb-3 text-white group-hover:text-yellow-300 transition-colors line-clamp-2">{{ $article->title }}</h4>
                <p class="text-sm text-white/70">
                  {{ $article->author ?? 'Admin' }} — 
                  @if($article->published_at)
                    {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}
                  @else
                    {{ $article->created_at->format('d M Y') }}
                  @endif
                </p>
              </div>
            </article>
          </a>
        @endforeach
      </div>

      <div class="mt-12">
        {{ $articles->links() }}
      </div>
    @else
      <div class="text-center py-16">
        <div class="inline-block p-6 bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl">
          <svg class="w-16 h-16 text-white/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <p class="text-xl text-white/70">Tidak ada artikel ditemukan.</p>
        </div>
      </div>
    @endif
  </div>
</section>

@endsection
