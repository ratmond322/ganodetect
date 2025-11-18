{{-- resources/views/layouts/guest.blade.php --}}
@php /* layout tunggal: dipakai sebagai component (<x-guest-layout>) atau @extends */ @endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Ganodetect') }}</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  @if(request()->boolean('fx') || config('app.ui_fx'))
    <link rel="stylesheet" href="https://unpkg.com/open-props" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  @endif
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @stack('styles')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter bg-brandLight text-gray-800 antialiased min-h-screen">

  @hasSection('header')
    @yield('header')
  @else
    @include('partials.header') {{-- default header --}}
  @endif

  <main class="min-h-[60vh] pt-24 md:pt-28">
    @isset($slot)
      {{ $slot }}
    @else
      @yield('content')
    @endisset
  </main>

  @hasSection('footer')
    @yield('footer')
  @else
    @include('partials.footer')
  @endif
  <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    try{
      if(window.AOS){
        AOS.init({
          once: false,           // animate every time it enters viewport
          mirror: true,          // animate out while scrolling past
          duration: 600,
          easing: 'ease-out-cubic'
        });
        // Refresh AOS on page show (e.g., bfcache) and after fonts load
        window.addEventListener('pageshow', function(){ try{ AOS.refreshHard(); }catch(e){} });
        if(document.fonts && document.fonts.ready){ document.fonts.ready.then(function(){ try{ AOS.refresh(); }catch(e){} }); }
      }
    }catch(e){}
  </script>
  @if(request()->boolean('fx') || config('app.ui_fx'))
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.28/bundled/lenis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
      (function(){
        try{
          const lenis = new Lenis({ smoothWheel:true, wheelMultiplier:1.1 });
          function raf(time){ lenis.raf(time); requestAnimationFrame(raf); } requestAnimationFrame(raf);
          // Keep AOS in sync with Lenis smooth scrolling
          try{ lenis.on('scroll', function(){ if(window.AOS){ AOS.refresh(); } }); }catch(e){}
        }catch(e){}
        try{
          if(document.querySelector('.swiper') && window.Swiper){
            new Swiper('.swiper',{ loop:true, autoplay:{delay:3500}, pagination:{el:'.swiper-pagination', clickable:true}, slidesPerView:1, spaceBetween:16, breakpoints:{768:{slidesPerView:2},1024:{slidesPerView:3}}});
          }
        }catch(e){}
      })();
    </script>
  @endif
  @stack('scripts')
</body>
</html>
