@extends('layouts.guest')

@section('content')
{{-- Header dipindahkan ke partials/header.blade.php --}}

<!-- ===== HERO =====
  NOTE:
  - Header is fixed and overlays the hero.
  - We intentionally DO NOT add a spacer above the hero; header overlays the hero image.
  - Add top padding on the hero content so the big headline is visible below the fixed header.
-->
<section class="relative bg-cover bg-center -mt-24 md:-mt-28 scroll-fade" style="background-image: url('{{ asset('images/hero.jpg') }}')">
  <!-- dark overlay to improve text contrast -->
  <div class="absolute inset-0 bg-black/50"></div>
  <!-- gradient transition to ganodetect section -->
  <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-b from-transparent via-[#1a2312]/60 to-[#2d3a1f]"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 md:py-24 lg:py-28">
    <!-- wrapper untuk membatasi lebar teks seperti di Figma (W = 844) -->
    <div class="mx-auto w-full max-w-[844px]">
      <div class="relative">
        <!-- ensure hero text is shifted down a bit so it doesn't collide with fixed header -->
        <div class="pt-16 md:pt-20 lg:pt-24"></div>

        <!-- teks hero -->
        <style>
          .hero-pro-title{ 
            font-weight: 800; 
            font-size: clamp(36px, 8vw, 104px); 
            line-height: 1.04; 
            letter-spacing: -0.02em; 
            text-wrap: balance; 
            color: #fff; 
            text-shadow: 0 10px 28px rgba(0,0,0,.35);
          }
          .hero-pro-accent{
            background: linear-gradient(90deg,#ffffff 0%, #fff7b2 35%, #ffe66d 70%, #fff 100%);
            -webkit-background-clip: text; background-clip: text; 
            -webkit-text-fill-color: transparent; color: transparent;
            filter: drop-shadow(0 6px 18px rgba(255,230,109,.25));
          }
          /* reveal per-baris ala fintech */
          .reveal-line{ display:block; overflow:hidden; }
          .reveal-line > span{ display:inline-block; transform: translateY(110%); opacity:.001; animation: lineUp .8s cubic-bezier(.2,.6,.2,1) both; }
          @keyframes lineUp{ to{ transform: translateY(0); opacity:1; } }
        </style>
        <h1 class="hero-pro-title text-center">
          <span class="reveal-line"><span>Melihat yang tak terlihat.</span></span>
          <span class="reveal-line" style="animation-delay:.25s"><span>Melindungi Perkebunan <span class="hero-pro-accent">Kelapa Sawit</span> Anda.</span></span>
        </h1>

        <div class="mt-6 md:mt-8 lg:mt-10"></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHAT'S ON GANODETECT — FLOATING CARDS ===== -->
<section id="ganodetect-section" class="relative bg-gradient-to-b from-[#2d3a1f] via-[#3a4a28] to-[#2d3a1f] overflow-hidden" style="min-height:100vh">
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-40"></div>
  
  <!-- Sticky container untuk heading dan cards -->
  <div class="sticky top-0 h-screen flex items-center justify-center">
    <div class="relative max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full">
      
      <!-- Heading besar di tengah (akan scale dari besar ke kecil) -->
      <div id="gano-heading" class="relative z-10 text-center">
        <h2 class="text-6xl md:text-7xl lg:text-8xl font-extrabold text-white leading-tight">
          Whats on<br/>
          <span class="text-white">Ganodetect?</span>
        </h2>
        <p id="gano-subtitle" class="text-white/70 text-lg md:text-xl mt-6 max-w-2xl mx-auto">Insight real-time kondisi kebun Anda</p>
      </div>

      <!-- Container untuk cards (akan fade in saat heading mengecil) -->
      <div id="cards-container" class="absolute inset-0 pointer-events-none">
        
      <!-- Card 1: Deteksi Ganoderma (kiri atas) -->
      <div class="gano-card absolute w-[220px] sm:w-[240px] lg:w-[260px] pointer-events-auto" data-card="1" data-scale="1.0">
        <div class="card-inner bg-gradient-to-br from-[#ff6b4a] to-[#ff8c6b] border-0 text-white">
          <div class="mb-3">
            <p class="text-xs font-semibold opacity-90 mb-1">Deteksi Ganoderma</p>
            <h3 class="text-xl font-bold mb-3">"Ganoderma<br/>Detected"</h3>
          </div>
          <div class="space-y-1 text-sm">
            <p>Tingkat infeksi: <span class="font-bold text-lg">12%</span></p>
            <p>Status: <span class="font-semibold">Early Stage</span></p>
          </div>
          <div class="mt-4 text-3xl opacity-60">🍄</div>
        </div>
      </div>

      <!-- Card 2: Estimasi Kerugian (kanan atas) -->
      <div class="gano-card absolute w-[220px] sm:w-[240px] lg:w-[260px] pointer-events-auto" data-card="2" data-scale="1.0">
        <div class="card-inner bg-gradient-to-br from-[#10b981] to-[#34d399] border-0 text-white">
          <p class="text-xs font-semibold opacity-90 mb-2">Est. Kerugian Panen</p>
          <p class="text-3xl font-bold mb-2">− Rp 2.180.000</p>
          <p class="text-sm">Pencegahan hemat <span class="font-semibold">Rp 920.000</span></p>
        </div>
      </div>

      <!-- Card 3: Lokasi Hotspot (kanan tengah) -->
      <div class="gano-card absolute w-[230px] sm:w-[240px] lg:w-[260px] pointer-events-auto" data-card="3" data-scale="0.88">
        <div class="card-inner bg-gradient-to-br from-[#4a5a3a] to-[#5a6a4a] border border-white/10 text-white backdrop-blur-lg">
          <p class="text-xs font-semibold opacity-90 mb-2">Lokasi Pohon Terdeteksi</p>
          <h3 class="text-xl font-bold mb-1">Hotspot: Blok C-12</h3>
          <p class="text-sm mb-3">3 pohon berisiko tinggi</p>
          <a href="#" class="text-sm text-green-300 hover:text-green-200 transition">Klik untuk lihat peta →</a>
        </div>
      </div>

      <!-- Card 4: Tree Health Score (kiri atas-tengah) -->
      <div class="gano-card absolute w-[230px] sm:w-[240px] lg:w-[260px] pointer-events-auto" data-card="4" data-scale="0.92">
        <div class="card-inner bg-gradient-to-br from-[#3a4a2a] to-[#4a5a3a] border border-white/10 text-white backdrop-blur-lg">
          <p class="text-xs font-semibold opacity-90 mb-2">Tree Health Score</p>
          <div class="flex items-baseline gap-2 mb-1">
            <span class="text-2xl">🌿</span>
            <span class="text-4xl font-extrabold">87</span>
            <span class="text-xl opacity-70">/100</span>
            <span class="text-base font-semibold">— Baik</span>
          </div>
          <p class="text-xs opacity-60 mt-2">Update: 2 jam yang lalu</p>
        </div>
      </div>

      <!-- Card 5: Drone Status (kiri bawah) -->
      <div class="gano-card absolute w-[240px] sm:w-[250px] lg:w-[270px] pointer-events-auto" data-card="5" data-scale="0.88">
        <div class="card-inner bg-gradient-to-br from-[#3a4a2a] to-[#4a5a3a] border border-white/10 text-white backdrop-blur-lg">
          <h3 class="text-lg font-bold mb-2">Drone #3 – Active</h3>
          <div class="space-y-1 text-sm">
            <p>Status: <span class="font-semibold">Surveying area</span></p>
            <p>Battery: <span class="font-semibold text-green-400">78%</span></p>
          </div>
        </div>
      </div>

      <!-- Card 6: Rekomendasi (kanan bawah) -->
      <div class="gano-card absolute w-[240px] sm:w-[250px] lg:w-[270px] pointer-events-auto" data-card="6" data-scale="0.95">
        <div class="card-inner bg-gradient-to-br from-[#fbbf24] to-[#fcd34d] border-0 text-gray-900">
          <p class="text-xs font-semibold opacity-80 mb-2">Rekomendasi</p>
          <p class="text-base font-bold mb-3">"Lakukan pengeboran<br/>batang 15 cm."</p>
          <p class="text-sm font-bold text-red-600">Priority: Tinggi ⚠</p>
        </div>
      </div>      </div>
    </div>
  </div>
  <!-- gradient transition to location section -->
  <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-b from-transparent via-[#151715]/60 to-[#1E201E] pointer-events-none"></div>
</section>

<!-- ================= INFECTION CHART ================= -->
{{-- <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-brandLight scroll-fade" data-aos="fade-up">
  <h3 class="text-3xl font-semibold text-gray-900 mb-6">Tren Infeksi</h3>
  <canvas id="infectionChart" class="w-full h-72"></canvas>

  <!-- Chart.js via CDN (fallback jika Vite bermasalah) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" integrity="sha256-gk4o0v7lYA9b/6qslcYN0oZ7b8qW4jv0zZQvJ1C8ycE=" crossorigin="anonymous"></script>
  <script>
    (function() {
      if (!window.Chart) return; // aman jika gagal load
      const ctx = document.getElementById('landingChart')?.getContext('2d');
      if (!ctx) return;
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan','Feb','Mar','Apr','May','Jun'],
          datasets: [{
            label: 'Kasus Terdeteksi',
            data: [5, 9, 7, 12, 10, 15],
            borderColor: '#1f2937',
            backgroundColor: 'rgba(31,41,55,0.15)',
            tension: 0.25,
            fill: true,
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: true } },
          scales: { y: { beginAtZero: true } }
        }
      });
    })();
  </script>
</section> --}}

<!-- ================= MAP + SIDE TEXT ================= -->
<section id="lokasi" class="relative w-full h-screen text-white scroll-fade flex items-center" style="background-color: #1E201E;" data-aos="fade-up">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section label (pill) -->
    <div class="mb-8">
      <span class="inline-block rounded-full px-4 py-2 bg-white/10 text-yellow-300 font-semibold tracking-wide backdrop-blur">
        Tempat Kami Beroperasi
      </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-stretch">
      <!-- Map column -->
      <div class="md:col-span-7">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <div id="landingMap" class="w-full h-[65vh] md:h-[70vh] rounded-xl overflow-hidden ring-1 ring-white/10"></div>
      </div>

      <!-- Text column -->
      <div class="md:col-span-5 md:border-l md:border-white/30 md:pl-8 flex">
        <div class="self-center">
          <p class="text-2xl md:text-3xl font-semibold leading-tight">
            berbasis di Bogor,
            <br class="hidden md:block"/>
            dengan komitmen untuk
            <br class="hidden md:block"/>
            terus berkembang dan
            <br class="hidden md:block"/>
            memperluas jangkauan
            <br class="hidden md:block"/>
            layanan ke <span class="text-yellow-300 font-extrabold">seluruh
            wilayah di indonesia</span> demi
            <br class="hidden md:block"/>
            mendukung
            <br class="hidden md:block"/>
            kesejahteraan petani
            <br class="hidden md:block"/>
            kelapa sawit secara
            <br class="hidden md:block"/>
            berkelanjutan
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    (function(){
      if (!window.L) return;
      const mapEl = document.getElementById('landingMap');
      if (!mapEl) return;
      const map = L.map(mapEl).setView([-6.5971, 106.8060], 12); // Bogor
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);
      L.marker([-6.5971, 106.8060]).addTo(map).bindPopup('Ganodetect - Bogor');
    })();
  </script>
</section>

<!-- ================= TESTIMONIALS ================= -->
<section id="testimonials-section" class="relative w-full min-h-screen bg-cover bg-top overflow-hidden flex items-center justify-center" style="background-image: url('{{ asset('images/apa-kata-mereka.jpg') }}')">
  <div class="absolute inset-0 bg-black/60"></div>
  
  @php
    $initials = function($name){
      $parts = preg_split('/[\s\-]+/', trim($name));
      $letters = '';
      foreach($parts as $p){ if($p!==''){ $letters .= mb_strtoupper(mb_substr($p,0,1)); } }
      return $letters;
    };
  @endphp
  <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <h2 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white text-center mb-16">Apa Kata Mereka?</h2>
    
    <div id="testimonials-container" class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="testimonial-card" data-testimonial="1">
        <div class="glass-card backdrop-blur-xl bg-white/10 border border-white/20 p-6 rounded-2xl shadow-2xl">
          <p class="text-white mb-6 text-base leading-relaxed">Drone-nya sangat bagus dan diberikan guide yang sangat lengkap untuk membasmi ganoderma.</p>
          <footer class="flex items-center gap-4">
            <span class="initial-badge bg-white/90 text-[#1E201E] ring-2 ring-white/30">{{ $initials('Petani-XXXX') }}</span>
            <span class="font-semibold text-white">Petani-XXXX</span>
          </footer>
        </div>
      </div>

      <div class="testimonial-card" data-testimonial="2">
        <div class="glass-card backdrop-blur-xl bg-white/10 border border-white/20 p-6 rounded-2xl shadow-2xl">
          <p class="text-white mb-6 text-base leading-relaxed">Bagus walaupun rada mahal tapi worth it.</p>
          <footer class="flex items-center gap-4">
            <span class="initial-badge bg-white/90 text-[#1E201E] ring-2 ring-white/30">{{ $initials('Koh Ferry') }}</span>
            <span class="font-semibold text-white">Koh Ferry</span>
          </footer>
        </div>
      </div>

      <div class="testimonial-card" data-testimonial="3">
        <div class="glass-card backdrop-blur-xl bg-white/10 border border-white/20 p-6 rounded-2xl shadow-2xl">
          <p class="text-white mb-6 text-base leading-relaxed">GOKSSSSSSSSSSSSSS!</p>
          <footer class="flex items-center gap-4">
            <span class="initial-badge bg-white/90 text-[#1E201E] ring-2 ring-white/30">{{ $initials('Mon') }}</span>
            <span class="font-semibold text-white">Mon</span>
          </footer>
        </div>
      </div>
    </div>
  </div>
</section>

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
              @if($article->image)
                <img src="{{ asset('images/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-56 object-cover pointer-events-none">
              @else
                <div class="w-full h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400">
                  <span class="text-sm">No image</span>
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


<!-- Footer diglobalisasi via partials/footer.blade.php dari layout. -->
@endsection

@push('styles')
<style>
  .scroll-fade{opacity:1;transition:opacity .35s ease;will-change:opacity}
  .scroll-fade.is-fade-out{opacity:.12}
  .scroll-fade.is-fade-in-start{opacity:.3}
  @media (prefers-reduced-motion: reduce){.scroll-fade{transition:none}}

  /* Floating cards glassmorphism */
  .gano-card{
    will-change:transform,opacity;
  }
  .card-inner{
    padding:1.5rem;
    border-radius:1.25rem;
    backdrop-filter:blur(16px);
    box-shadow:0 8px 32px rgba(0,0,0,.3), 0 2px 8px rgba(0,0,0,.2), inset 0 1px 0 rgba(255,255,255,.1);
    transition:transform .4s cubic-bezier(.4,0,.2,1), box-shadow .4s ease;
  }
  .card-inner:hover{
    transform:translateY(-6px) scale(1.03);
    box-shadow:0 20px 60px rgba(0,0,0,.4), 0 4px 16px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.15);
  }
  #gano-heading h2{
    text-shadow:0 8px 24px rgba(0,0,0,.35),0 0 16px rgba(120,200,120,.12),0 0 32px rgba(255,255,255,.15);
    filter:drop-shadow(0 0 8px rgba(152,251,152,.1));
    transition:text-shadow .6s ease,filter .6s ease;
  }
  /* Disable keyframe floating - let GSAP handle all animation */
  
  @media (max-width: 768px){
    .gano-card{ position:relative !important; top:auto !important; left:auto !important; right:auto !important; bottom:auto !important; margin:0 auto 1.5rem; }
  }
  
  @media (max-width: 768px){
    .gano-card{ position:relative !important; top:auto !important; left:auto !important; right:auto !important; bottom:auto !important; margin-bottom:1.5rem; }

    /* Testimonial cards glassmorphism & stacking animation */
    .testimonial-card{
      will-change:transform,opacity;
      transition:all .8s cubic-bezier(.4,0,.2,1);
    }
    .glass-card{
      transition:transform .4s ease,box-shadow .4s ease;
    }
    .glass-card:hover{
      transform:translateY(-8px);
      box-shadow:0 24px 48px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.2);
    }
    .initial-badge{
      display:inline-flex;
      align-items:center;justify-content:center;
      width:3rem;height:3rem;border-radius:9999px;
      font-weight:800;letter-spacing:.02em;font-size:1rem;
      border:2px solid rgba(255,255,255,.35);
      box-shadow:inset 0 1px 2px rgba(0,0,0,.15);
    }
  }
</style>
@endpush

@push('scripts')
<script>
  // GSAP ScrollTrigger for "cards dive into heading" effect
  (function(){
    if(!window.gsap || !window.ScrollTrigger) return;
    gsap.registerPlugin(ScrollTrigger);

    const section = document.getElementById('ganodetect-section');
    const heading = document.getElementById('gano-heading');
    const subtitle = document.getElementById('gano-subtitle');
    const cardsContainer = document.getElementById('cards-container');
    const cards = document.querySelectorAll('.gano-card');
    const containerEl = cardsContainer || section;

    if(!section || !heading || !cards.length) return;
    let whatsOnTimeline;

    function setupWhatsOnAnimation() {
      if (whatsOnTimeline) {
        whatsOnTimeline.scrollTrigger?.kill();
        whatsOnTimeline.kill();
      }

      const rect = containerEl.getBoundingClientRect();
      const layout = {
        '1': { x: -0.30, y: -0.40, scale: 1.00, z: 14 },
        '2': { x:  0.30, y: -0.50, scale: 1.00, z: 13 },
        '3': { x:  0.48, y:  0.04, scale: 0.90, z: 12 },
        '4': { x: -0.50, y: -0.02, scale: 0.92, z: 11 },
        '5': { x: -0.40, y:  0.75, scale: 0.90, z: 10 },
        '6': { x:  0.44, y:  0.75, scale: 0.94, z: 9 }
      };
      const width = rect.width;
      const height = rect.height;

      // Timeline controlling heading, subtitle, and cards together
      whatsOnTimeline = gsap.timeline({
        defaults: { ease: 'power1.inOut' },
        scrollTrigger: {
          trigger: section,
          start: 'top top',
          end: '+=150vh',
          scrub: 2,
          pin: true,
          anticipatePin: 1,
          invalidateOnRefresh: true
        }
      });

      whatsOnTimeline.fromTo(heading, { scale: 2.5 }, { scale: 1 }, 0);
      whatsOnTimeline.to(subtitle, { opacity: 0, y: -20 }, 0);

      cards.forEach((card) => {
        const id = card.getAttribute('data-card');
        const cfg = layout[id] || { x: 0, y: 0, scale: 1, z: 5 };
        const targetX = cfg.x * width;
        const targetY = cfg.y * height;
        const scale = cfg.scale ?? parseFloat(card.dataset.scale || '1');

        gsap.killTweensOf(card);
        gsap.set(card, {
          position: 'absolute',
          left: '50%',
          top: '50%',
          xPercent: -50,
          yPercent: -50,
          x: 0,
          y: 0,
          scale: 0.4,
          opacity: 0,
          zIndex: cfg.z,
          transformOrigin: '50% 50%',
          clearProps: 'animation'
        });

        whatsOnTimeline.to(card, { x: targetX, y: targetY, scale, opacity: 1 }, 0);
      });
    }

    setupWhatsOnAnimation();
    window.addEventListener('resize', () => {
      setupWhatsOnAnimation();
      ScrollTrigger.refresh();
    }, { passive: true });

  })();

  // Original scroll-fade script
  (function(){
    const sections = Array.from(document.querySelectorAll('section.scroll-fade'));
    if(!sections.length) return;
    let lastY = window.scrollY;
    let activeIdx = getActiveIndex();

    function getActiveIndex(){
      const mid = window.scrollY + window.innerHeight * 0.5;
      for(let i=0;i<sections.length;i++){
        const rect = sections[i].getBoundingClientRect();
        const top = rect.top + window.scrollY;
        const bottom = top + rect.height;
        if(mid >= top && mid < bottom) return i;
      }
      // fallback: closest section above the middle
      let idx = 0, bestDist = Infinity;
      sections.forEach((s,i)=>{
        const top = s.getBoundingClientRect().top + window.scrollY;
        const dist = Math.abs((top + s.offsetHeight/2) - mid);
        if(dist < bestDist){ bestDist = dist; idx = i; }
      });
      return idx;
    }

    function onScroll(){
      const y = window.scrollY;
      const dirUp = y < lastY;
      const newIdx = getActiveIndex();
      if(dirUp && newIdx !== activeIdx){
        const from = sections[activeIdx];
        const to = sections[newIdx];
        if(from){ from.classList.add('is-fade-out'); }
        if(to){
          to.classList.remove('is-fade-out');
          // force a quick fade-in even if already opaque
          to.classList.add('is-fade-in-start');
          requestAnimationFrame(()=>{
            to.classList.remove('is-fade-in-start');
          });
        }
        // cleanup fade after transition so section doesn't stay dimmed
        if(from){
          setTimeout(()=>{ from.classList.remove('is-fade-out'); }, 450);
        }
        activeIdx = newIdx;
      }
      lastY = y;
    }

    // Initialize state
    sections.forEach(s=>s.classList.remove('is-fade-out'));
    window.addEventListener('scroll', onScroll, { passive:true });

    // Testimonial cards stacking scroll animation
    (function(){
      if(!window.gsap || !window.ScrollTrigger) return;
      const section = document.getElementById('testimonials-section');
      const cards = document.querySelectorAll('.testimonial-card');
      if(!section || !cards.length) return;

      cards.forEach((card, index) => {
        const reverseIndex = cards.length - 1 - index;
        gsap.set(card, {
          y: reverseIndex * 120,
          scale: 1 - (reverseIndex * 0.05),
          opacity: reverseIndex === 0 ? 1 : 0.3
        });

        ScrollTrigger.create({
          trigger: section,
          start: 'top center',
          end: 'bottom center',
          scrub: 1,
          onUpdate: (self) => {
            const progress = self.progress;
            const targetY = progress >= 0.5 ? 0 : reverseIndex * 120 * (1 - progress * 2);
            const targetOpacity = progress >= 0.3 ? 1 : 0.3 + (progress / 0.3) * 0.7;
            const targetScale = progress >= 0.5 ? 1 : 1 - (reverseIndex * 0.05) * (1 - progress * 2);
          
            gsap.to(card, {
              y: targetY,
              opacity: targetOpacity,
              scale: targetScale,
              duration: 0.3,
              ease: 'power1.out'
            });
          }
        });
      });
    })();
  })();

  // Article carousel with InteractJS drag
  (function(){
    const carousel = document.getElementById('article-carousel');
    const cards = document.querySelectorAll('.article-card');
    const prevBtn = document.getElementById('prev-article');
    const nextBtn = document.getElementById('next-article');
    const dots = document.querySelectorAll('.indicator-dot');
    
    if(!carousel || !cards.length) return;
    
    let currentIndex = 0;
    const totalCards = cards.length;
    
    function updateCarousel(skipTransition = false){
      cards.forEach((card, i) => {
        const offset = i - currentIndex;
        let x = offset * 420;
        let scale = 1;
        let opacity = 1;
        let zIndex = 10;
        
        if(offset === 0){
          scale = 1.1;
          zIndex = 30;
        } else if(Math.abs(offset) === 1){
          scale = 0.9;
          opacity = 0.7;
          zIndex = 20;
        } else {
          scale = 0.7;
          opacity = 0.3;
          zIndex = 10;
        }
        
        if(skipTransition){
          card.style.transition = 'none';
        } else {
          card.style.transition = 'transform 0.6s cubic-bezier(0.4,0,0.2,1), opacity 0.6s ease';
        }
        
        card.style.transform = `translateX(${x}px) scale(${scale})`;
        card.style.opacity = opacity;
        card.style.zIndex = zIndex;
        
        if(skipTransition){
          setTimeout(() => {
            card.style.transition = 'transform 0.6s cubic-bezier(0.4,0,0.2,1), opacity 0.6s ease';
          }, 10);
        }
      });
      
      dots.forEach((dot, i) => {
        if(i === currentIndex){
          dot.style.backgroundColor = 'rgba(255,255,255,0.9)';
          dot.style.transform = 'scale(1.2)';
        } else {
          dot.style.backgroundColor = 'rgba(255,255,255,0.3)';
          dot.style.transform = 'scale(1)';
        }
      });
    }
    
    function nextSlide(){
      currentIndex = (currentIndex + 1) % totalCards;
      updateCarousel();
    }
    
    function prevSlide(){
      currentIndex = (currentIndex - 1 + totalCards) % totalCards;
      updateCarousel();
    }
    
    if(prevBtn) prevBtn.addEventListener('click', prevSlide);
    if(nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    // InteractJS drag
    if(window.interact){
      cards.forEach((card) => {
        let startX = 0;
        let isDragging = false;
        
        interact(card)
          .draggable({
            inertia: true,
            modifiers: [
              interact.modifiers.restrict({
                restriction: 'parent',
                endOnly: false
              })
            ],
            listeners: {
              start(event){
                isDragging = true;
                startX = event.clientX;
                event.target.style.cursor = 'grabbing';
              },
              move(event){
                const dx = event.clientX - startX;
                if(Math.abs(dx) > 10){
                  event.target.style.transform += ` translateX(${event.dx}px)`;
                }
              },
              end(event){
                const dx = event.clientX - startX;
                event.target.style.cursor = 'grab';
                
                if(Math.abs(dx) > 100){
                  if(dx > 0){
                    prevSlide();
                  } else {
                    nextSlide();
                  }
                } else {
                  updateCarousel();
                }
                
                setTimeout(() => { isDragging = false; }, 100);
              }
            }
          })
          .on('tap', function(event){
            if(!isDragging){
              const url = event.currentTarget.dataset.url;
              if(url){
                window.location.href = url;
              }
            }
          });
      });
    }
    
    updateCarousel(true);
  })();
</script>
@endpush
