{{-- resources/views/products/show.blade.php --}}
@extends('layouts.guest')

@section('content')


<!-- MAIN PRODUCT AREA -->
<section class="bg-brandLight py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

      {{-- LEFT GALLERY --}}
      @php
        $fallbacks = ['shop1.jpg','shop2.jpg','shop3.jpg','shop4.jpg','shop5.jpg','shop6.jpg'];

        $productImages = [];
        if (!empty($product['images']) && is_array($product['images'])) {
          $productImages = $product['images'];
        } elseif (!empty($product['images']) && is_string($product['images'])) {
          $productImages = array_map('trim', explode(',', $product['images']));
        }

        $candidates = array_values(array_unique(array_merge($productImages, $fallbacks)));
        $available = [];
        foreach ($candidates as $c) {
          $file = basename(trim($c));
          if ($file && file_exists(public_path('images/' . $file))) {
            $available[] = $file;
          }
        }

        if (empty($available)) {
          foreach ($fallbacks as $fb) {
            if (file_exists(public_path('images/' . $fb))) $available[] = $fb;
          }
        }

        $mainSrc = $available[0] ?? null;
      @endphp

      <div class="flex flex-col gap-4">

        <div class="relative rounded-xl overflow-hidden shadow-lg bg-white">
          @if($mainSrc)
            <img id="mainImage" src="{{ asset('images/' . $mainSrc) }}" alt="{{ $product['title'] ?? $product['name'] ?? 'Product' }}" class="w-full max-h-[520px] object-cover">
          @else
            <div class="w-full h-[380px] flex items-center justify-center text-gray-400">No image found — check public/images</div>
          @endif

          @if($mainSrc)
            <button id="gallery-prev" aria-label="Previous" class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white px-3 py-2 rounded-full shadow-md z-40">‹</button>
            <button id="gallery-next" aria-label="Next" class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white px-3 py-2 rounded-full shadow-md z-40">›</button>
          @endif
        </div>

        <div class="flex gap-3 overflow-x-auto py-2">
          @foreach($available as $idx => $thumb)
            <!-- note: we don't toggle border to avoid layout shift; ring only -->
            <button class="thumb-btn rounded-md overflow-hidden focus:outline-none" data-index="{{ $idx }}" data-src="{{ asset('images/'.$thumb) }}" aria-label="Thumb {{ $idx + 1 }}">
              <img src="{{ asset('images/'.$thumb) }}" alt="thumb-{{ $idx + 1 }}" class="w-20 h-20 object-cover">
            </button>
          @endforeach
        </div>
      </div>

      {{-- RIGHT: product summary + spec-card --}}
      <div>

        <!-- summary box -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
          <h1 class="text-3xl font-bold mb-3">{{ $product['title'] ?? $product['name'] ?? 'Product' }}</h1>

          <p class="text-gray-600 leading-relaxed mb-4">
            {{ $product['excerpt'] ?? ($product['body'] ? \Illuminate\Support\Str::limit(strip_tags($product['body']), 180) : '') }}
          </p>

          @if(isset($product['price']))
            @php
              $rawPrice = $product['price'] ?? 0;
              $rawOriginal = $product['price_original'] ?? 0;
              $clean = preg_replace('/[^\d]/', '', (string)$rawPrice);
              $cleanOrig = preg_replace('/[^\d]/', '', (string)$rawOriginal);
              $priceVal = is_numeric($clean) ? (int)$clean : 0;
              $priceOrigVal = is_numeric($cleanOrig) ? (int)$cleanOrig : 0;
            @endphp

            <div class="mb-6">
              <span class="text-red-600 font-bold text-lg">-20% </span>
              <span class="font-bold text-xl">IDR {{ number_format($priceVal) }}</span>
              @if($priceOrigVal > 0)
                <div class="text-sm text-gray-400 line-through">IDR {{ number_format($priceOrigVal) }}</div>
              @endif
            </div>
          @endif

          <div class="flex gap-3">
            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo, saya tertarik dengan ' . ($product['title'] ?? $product['name'] ?? 'produk')) }}"
               target="_blank"
               class="px-5 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
              Hubungi via WhatsApp
            </a>

            <a id="seeMoreBtn" class="inline-block px-6 py-3 rounded-lg bg-black text-white font-medium shadow-sm hover:shadow-md transition cursor-pointer">
              See More
            </a>
          </div>
        </div>

        <!-- SPEC CARD -->
        <div id="spec-card" class="relative bg-white rounded-xl shadow-lg p-6">
          <div id="spec-overlay" class="absolute inset-0 pointer-events-none"></div>

          <!-- popup centered via CSS; add z-50 so clickable -->
          <div id="popup-center" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-auto z-50" style="opacity:0; transform:scale(0.95); transition: all 150ms;">
            <div class="bg-white/95 text-gray-900 px-4 py-2 rounded-full shadow-lg border border-gray-200 flex items-center gap-3">
              <span id="popup-label" class="text-sm font-medium">Show more</span>
            </div>
          </div>

          <h3 class="text-lg font-semibold mb-3">Spesifikasi Produk</h3>

          <div class="text-sm text-gray-800 grid grid-cols-1 md:grid-cols-2 gap-3">
            <div><strong>Brand:</strong> {{ $product['brand'] ?? '—' }}</div>
            <div><strong>Model Name:</strong> {{ $product['model_name'] ?? '—' }}</div>

            <div class="md:col-span-2"><strong>Special Feature:</strong>
              <div class="mt-1 text-gray-700">{{ \Illuminate\Support\Str::limit($product['special_feature'] ?? '-', 160) }}</div>
            </div>

            <div><strong>Color:</strong> {{ $product['color'] ?? '—' }}</div>
            <div><strong>Photo Resolution:</strong> {{ $product['photo_resolution'] ?? '—' }}</div>

            <div><strong>Capture:</strong> {{ $product['capture'] ?? '—' }}</div>
            <div><strong>Connectivity:</strong> {{ $product['connectivity'] ?? '—' }}</div>
          </div>

          <div id="spec-more" class="overflow-hidden mt-4" style="max-height:0; transition:max-height 350ms ease;">
            <div class="mt-4 border-t border-gray-100 pt-4 text-sm text-gray-800">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div><strong>Age Range:</strong> {{ $product['age_range'] ?? '—' }}</div>
                <div><strong>Skill Level:</strong> {{ $product['skill_level'] ?? '—' }}</div>

                <div class="md:col-span-2"><strong>Included Components:</strong>
                  <div class="mt-1 text-gray-700">{{ $product['included_components'] ?? '—' }}</div>
                </div>

                <div><strong>Item Weight:</strong> {{ $product['item_weight'] ?? '—' }}</div>

                <div class="md:col-span-2"><strong>Full Special Feature:</strong>
                  <div class="mt-1 text-gray-700">{{ $product['special_feature'] ?? '—' }}</div>
                </div>

                <div class="md:col-span-2"><strong>Full Description / Notes:</strong>
                  <div class="mt-1 text-gray-700">{!! $product['body'] ?? '<em>Tidak ada informasi tambahan.</em>' !!}</div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- end spec-card -->

      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-brandOlive text-white py-10 mt-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between">
    <div>
      <p class="font-bold text-xl">SEKOLAH VOKASI IPB</p>
      <p class="text-sm mt-1">
        Jl. Kumbang No.14, RT.02/RW.06, Babakan, Kecamatan Bogor Tengah,<br> Kota Bogor, Jawa Barat 16128.
      </p>
      <p class="mt-3 text-sm">info@ganodetect.com</p>
    </div>
    <div class="text-sm self-end mt-6 md:mt-0">© {{ date('Y') }} Ganodetect. All rights reserved.</div>
  </div>
</footer>

<!-- SCRIPTS -->
<script>
  // mobile menu
  (function () {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
      menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    }
  })();

  // gallery: hover thumbnails -> change main image ; arrows prev/next ; keyboard support
  (function () {
    const main = document.getElementById('mainImage');
    if (!main) return;
    const thumbs = Array.from(document.querySelectorAll('.thumb-btn'));
    const prev = document.getElementById('gallery-prev');
    const next = document.getElementById('gallery-next');

    const srcList = thumbs.map(t => t.dataset.src).filter(Boolean);
    let current = 0;

    function setIndex(i) {
      if (!srcList.length) return;
      current = (i + srcList.length) % srcList.length;
      main.src = srcList[current];
      thumbs.forEach((t, idx) => {
        // use ring (outline) not border to avoid layout shift
        t.classList.toggle('ring-2', idx === current);
        t.classList.toggle('ring-offset-2', idx === current);
        t.classList.toggle('ring-brandOlive/30', idx === current);
      });
      // DO NOT call scrollIntoView vertical/horizontal to keep thumbnails stable
    }

    (function init() {
      if (main.src && srcList.length) {
        const match = srcList.findIndex(s => s === main.src || s === new URL(main.src, location.href).href);
        current = match >= 0 ? match : 0;
        setIndex(current);
      }
    })();

    thumbs.forEach((btn, idx) => {
      btn.addEventListener('mouseenter', () => setIndex(idx));
      btn.addEventListener('focus', () => setIndex(idx));
      btn.addEventListener('click', (e) => { e.preventDefault(); setIndex(idx); });
      btn.addEventListener('keydown', (ev) => { if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); setIndex(idx); } });
    });

    if (prev) prev.addEventListener('click', (e) => { e.preventDefault(); setIndex(current - 1); });
    if (next) next.addEventListener('click', (e) => { e.preventDefault(); setIndex(current + 1); });

    document.addEventListener('keydown', (ev) => {
      const tag = (ev.target && ev.target.tagName) || '';
      if (tag === 'INPUT' || tag === 'TEXTAREA' || ev.target.isContentEditable) return;
      if (ev.key === 'ArrowLeft') setIndex(current - 1);
      if (ev.key === 'ArrowRight') setIndex(current + 1);
    });

    srcList.forEach(s => { const img = new Image(); img.src = s; });
  })();

  // popup show-more script (kept your logic, minor fixes: popup z-index handled in CSS; click outside to close)
  (function () {
    const specCard = document.getElementById('spec-card');
    const popup = document.getElementById('popup-center');
    const specMore = document.getElementById('spec-more');
    const overlay = document.getElementById('spec-overlay');
    const popupLabel = document.getElementById('popup-label');

    if (!specCard || !popup || !specMore || !overlay || !popupLabel) return;

    function setBlur(enable) {
      specCard.querySelectorAll(':scope > *:not(#popup-center)').forEach(el => {
        el.style.transition = 'filter 160ms linear';
        el.style.filter = enable ? 'blur(4px)' : '';
      });
      overlay.style.background = enable ? 'rgba(255,255,255,0.28)' : 'transparent';
      overlay.style.opacity = enable ? '0.6' : '0';
    }

    function showPopup() {
      if (specCard.classList.contains('spec-expanded')) return;
      popup.style.opacity = '1';
      popup.style.pointerEvents = 'auto';
      popup.style.transform = 'scale(1)';
    }

    function hidePopup() {
      popup.style.opacity = '0';
      popup.style.pointerEvents = 'none';
      popup.style.transform = 'scale(0.95)';
    }

    function expandSpecs() {
      specMore.style.maxHeight = specMore.scrollHeight + 'px';
      hidePopup();
      popupLabel.textContent = 'Show less';
      specCard.classList.add('spec-expanded');
      setBlur(false);
    }

    function collapseSpecs() {
      specMore.style.maxHeight = '0';
      popupLabel.textContent = 'Show more';
      specCard.classList.remove('spec-expanded');
      hidePopup();
      setBlur(false);
    }

    // OPEN: click popup
    popup.addEventListener('click', function (e) {
      e.stopPropagation();
      expandSpecs();
      setTimeout(() => {
        try {
          specCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } catch (err) {
          specCard.scrollIntoView();
        }
      }, 150);
    });

    // Hover show
    specCard.addEventListener('mouseenter', () => {
      if (!specCard.classList.contains('spec-expanded')) {
        showPopup();
        setBlur(true);
      }
    });

    specCard.addEventListener('mouseleave', () => {
      if (!specCard.classList.contains('spec-expanded')) {
        hidePopup();
        setBlur(false);
      }
    });

    // CLOSE: click outside when expanded
    document.addEventListener('click', function (e) {
      const isExpanded = specCard.classList.contains('spec-expanded');
      if (!isExpanded) return;
      if (!specCard.contains(e.target)) {
        collapseSpecs();
      }
    });

    window.addEventListener('resize', () => {
      if (specCard.classList.contains('spec-expanded')) {
        specMore.style.maxHeight = specMore.scrollHeight + 'px';
      }
    });
  })();
</script>

@endsection
