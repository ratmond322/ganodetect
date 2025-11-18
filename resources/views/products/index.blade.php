{{-- resources/views/products/index.blade.php --}}
@extends('layouts.guest')

@section('content')


{{-- Header & mobile menu sudah disediakan oleh layouts.guest (partials.header). Hapus duplikasi di sini. --}}

<!-- HERO FINAL (tanpa border, teks naik) -->
<section class="relative w-full min-h-screen">
  
  <!-- Background -->
  <div class="absolute inset-0 pointer-events-none">
    <img src="{{ asset('images/hero-shop.jpg') }}"
         class="w-full h-full object-cover object-center" />
  </div>

  <!-- Overlay gradient -->
  <div class="absolute inset-0 pointer-events-none"
       style="background: linear-gradient(
                to bottom,
                rgba(0,0,0,0.55) 0%,
                rgba(0,0,0,0.35) 25%,
                rgba(0,0,0,0.08) 60%,
                rgba(0,0,0,0) 100%
              );">
  </div>

  <!-- Spacer removed (layout header handles its own spacing) -->

  <!-- HERO CONTENT -->
  <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-6">

      <h1 class="text-white font-extrabold 
                 text-5xl sm:text-6xl md:text-7xl lg:text-[96px]
                 leading-tight md:leading-[0.9] tracking-tight text-center">
        SHOP <span class="block">NOW</span>
      </h1>

      <p class="mt-4 md:mt-6 text-white/80 text-sm md:text-base max-w-2xl mx-auto text-center">
        Explore produk kami — drone inspeksi dan solusi Ganoderma untuk perkebunan.
      </p>

      <div class="mt-6 md:mt-8">
        <a href="#products-section"
           class="inline-block px-8 py-3 rounded-full bg-white text-black font-semibold shadow-lg hover:shadow-2xl transition">
          Shop Products
        </a>
      </div>

  </div>
</section>


<!-- MAIN CONTENT: product card with hover-interaction -->
<section id="products-section" class="relative bg-brandLight py-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

    <!-- Overlay that will blur/darken background when hovering the card.
         pointer-events-none so it doesn't block clicks; class added/removed by JS -->
    <div id="products-overlay"
         class="absolute inset-0 pointer-events-none transition-all duration-300 ease-out">
      <!-- initially transparent; JS will add classes to enable blur & darken -->
    </div>

    <div class="relative mt-32 md:mt-40 lg:mt-48 flex justify-center">
      <!-- CARD: center, limited width -->
      <article
  class="product-card w-full max-w-[1100px] bg-white text-black rounded-2xl 
         overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-6 p-6 md:p-10 z-30 relative 
         transform transition-transform duration-300 ease-out hover:scale-105 
         shadow-[0_20px_50px_-10px_rgba(0,0,0,0.15)] hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.25)] cursor-pointer">

        <div class="flex items-center justify-center">
          <img src="{{ asset('images/drone-shop.jpg') }}"
               alt="GANODETECT AG-450S"
               class="w-full max-w-[640px] rounded-lg object-cover h-56 md:h-72 lg:h-80">
        </div>

        <!-- right: content -->
        <div class="flex flex-col justify-center gap-6">
          <h2 class="text-3xl md:text-4xl lg:text-5xl font-jet uppercase tracking-widest">
            GANODETECT AG-450S
          </h2>

          <p class="text-zinc-700 leading-relaxed text-sm md:text-base">
            An Autonomous AI Inspection Drone featuring an 8MP NoIR Camera,
            Raspberry Pi 4 Processing, Pixhawk Waypoint Navigation,
            and Integrated Precision Sprayer for Ganoderma Treatment.
          </p>

          <div>
            <a href="{{ route('products.show', 'ag-450s') }}"
   class="inline-block px-6 py-3 rounded-lg bg-black text-white font-medium shadow-sm hover:shadow-md transition">
  More
</a>

          </div>
        </div>
      </article>
    </div>
  </div>

  <!-- JS to toggle overlay class when product-card is hovered -->
  <script>
    (function () {
      const card = document.getElementById('product-card');
      const overlay = document.getElementById('products-overlay');

      if (!card || !overlay) return;

      const enableOverlay = () => {
        overlay.classList.add('backdrop-blur-sm', 'bg-black/20', 'opacity-100');
        // small vertical gradient so card area doesn't fully darken
        overlay.style.background = 'linear-gradient(to bottom, rgba(0,0,0,0.12), rgba(0,0,0,0.08) 40%, rgba(0,0,0,0))';
      };

      const disableOverlay = () => {
        overlay.classList.remove('backdrop-blur-sm', 'bg-black/20', 'opacity-100');
        overlay.style.background = 'transparent';
      };

      // pointer events: use mouseenter/mouseleave for desktop
      card.addEventListener('mouseenter', enableOverlay);
      card.addEventListener('mouseleave', disableOverlay);

      // also support keyboard focus (accessibility)
      card.addEventListener('focusin', enableOverlay);
      card.addEventListener('focusout', disableOverlay);
    })();
  </script>
</section>




<!-- CTA -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
  <div class="bg-[#cbbdae] rounded-xl p-8 text-center">
    <h3 class="text-3xl font-semibold text-gray-800">More Coming Really Soon</h3>
  </div>
</section>

<!-- Jika perlu tambahkan section lain (mis. specs, gallery) di sini menggunakan container max-w-7xl -->

{{-- Footer ditarik dari partials/footer.blade.php melalui layouts.guest --}}

<!-- MOBILE MENU SCRIPT (sama dengan welcome.blade.php) -->
<script>
  // Mobile menu handled globally; no duplicate script needed.
</script>
@endsection
