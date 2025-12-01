@extends('layouts.guest')

@section('content')

<!-- ===== HERO TENTANG ===== -->
<section class="relative bg-cover bg-center -mt-24 md:-mt-28 overflow-hidden" style="background-image: url('{{ asset('images/drone-tentang.jpg') }}')">
  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black/50"></div>
  
  <!-- Pattern background -->
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-20"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid lg:grid-cols-2 gap-12 items-center min-h-screen py-32">
      
      <!-- Left Content -->
      <div class="space-y-8" data-aos="fade-right">
        <div class="inline-block">
          <span class="text-xs uppercase tracking-wider text-yellow-300 font-semibold bg-white/10 px-4 py-2 rounded-full backdrop-blur">
            Scroll
          </span>
        </div>
        
        <div class="space-y-6">
          <h1 class="text-6xl md:text-7xl lg:text-8xl font-extrabold text-white leading-none tracking-tight">
            Teknologi kita.<br>
            <span class="bg-gradient-to-r from-[#10b981] via-[#34d399] to-[#10b981] bg-clip-text text-transparent">
              Cara kita.
            </span>
          </h1>
        </div>
      </div>

      <!-- Right Content -->
      <div class="space-y-8" data-aos="fade-left">
        <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl">
          <p class="text-xl md:text-2xl text-white/90 leading-relaxed mb-8">
            Membuat deteksi penyakit kelapa sawit mudah, akurat, ramah, dan menyenangkan.
          </p>
          
          <a href="https://wa.me/6285122983440?text=Halo%20Ganodetect%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20deteksi%20penyakit%20kelapa%20sawit" target="_blank" class="inline-flex items-center gap-2 bg-white text-[#2d3a1f] px-8 py-4 rounded-full font-semibold text-lg hover:bg-yellow-300 transition-all duration-300 transform hover:scale-105 shadow-lg">
            Mari terhubung
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===== VISI SECTION ===== -->
<section id="personal" class="relative overflow-hidden" style="background-image: url('{{ asset('images/kantor.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 110vh;">
  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black/60"></div>
  
  <!-- Pattern background -->
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-20"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex items-center justify-center" style="min-height: 110vh;">
    <div class="w-full py-24">
      <div class="text-center mb-16" data-aos="fade-up">
        <span class="inline-block rounded-full px-4 py-2 bg-white/10 text-yellow-300 font-semibold tracking-wide backdrop-blur mb-4">
          Visi Kami
        </span>
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mt-4">
          Untuk Petani
        </h2>
      </div>

      <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
      <div class="bg-gradient-to-br from-[#10b981] to-[#34d399] p-8 rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4">Akurasi Tinggi</h3>
        <p class="text-white/90 text-lg leading-relaxed">
          Menggunakan teknologi AI terdepan untuk mendeteksi penyakit Ganoderma dengan akurasi tinggi, membantu petani mengambil keputusan yang tepat.
        </p>
      </div>

      <div class="bg-gradient-to-br from-[#4a5a3a] to-[#5a6a4a] p-8 rounded-3xl shadow-2xl border border-white/10 backdrop-blur transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4">Cepat & Mudah</h3>
        <p class="text-white/90 text-lg leading-relaxed">
          Sistem deteksi yang cepat dan mudah digunakan, bahkan untuk petani yang baru pertama kali menggunakan teknologi drone.
        </p>
      </div>
    </div>
    </div>
  </div>
</section>

<!-- ===== MISI SECTION ===== -->
<section id="business" class="relative overflow-hidden" style="background-image: url('{{ asset('images/senyum.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 110vh;">
  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black/60"></div>
  
  <!-- Pattern background -->
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-20"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex items-center justify-center" style="min-height: 110vh;">
    <div class="w-full py-24">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block rounded-full px-4 py-2 bg-white/10 text-yellow-300 font-semibold tracking-wide backdrop-blur mb-4">
        Misi Kami
      </span>
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mt-4">
        Untuk Perkebunan
      </h2>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-8 rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-gradient-to-br from-[#ff6b4a] to-[#ff8c6b] rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4">Pencegahan Dini</h3>
        <p class="text-white/80 text-lg leading-relaxed">
          Mendeteksi gejala penyakit sejak dini untuk mencegah penyebaran lebih luas di perkebunan.
        </p>
      </div>

      <div class="bg-gradient-to-br from-[#fbbf24] to-[#fcd34d] p-8 rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Efisiensi Biaya</h3>
        <p class="text-gray-900/80 text-lg leading-relaxed">
          Mengurangi kerugian hasil panen dan biaya perawatan dengan deteksi yang akurat dan tepat waktu.
        </p>
      </div>

      <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-8 rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="300">
        <div class="w-16 h-16 bg-gradient-to-br from-[#10b981] to-[#34d399] rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4">Produktivitas Maksimal</h3>
        <p class="text-white/80 text-lg leading-relaxed">
          Membantu meningkatkan produktivitas perkebunan dengan monitoring yang konsisten dan berkelanjutan.
        </p>
      </div>
    </div>
    </div>
  </div>
</section>

<!-- ===== TIM SECTION ===== -->
<section id="company" class="relative bg-gradient-to-b from-[#1a2312] to-[#2d3a1f] py-24 overflow-hidden">
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-40"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="inline-block rounded-full px-4 py-2 bg-white/10 text-yellow-300 font-semibold tracking-wide backdrop-blur mb-4">
        Tim Kami
      </span>
      <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mt-4">
        Tim Dibalik Ganodetect
      </h2>
      <p class="text-xl text-white/70 mt-6 max-w-3xl mx-auto">
        Kami adalah tim yang passionate dalam teknologi pertanian dan berkomitmen untuk membantu petani Indonesia.
      </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Team Member 1 -->
      <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-6 rounded-3xl shadow-2xl text-center transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="100">
        <div class="w-24 h-24 bg-gradient-to-br from-[#10b981] to-[#34d399] rounded-full mx-auto mb-4 flex items-center justify-center">
          <span class="text-3xl font-bold text-white">R</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Radyanka</h3>
        <p class="text-yellow-300 text-sm mb-3">CEO</p>
        <p class="text-white/70 text-sm">Memimpin visi dan strategi pengembangan Ganodetect</p>
      </div>

      <!-- Team Member 2 -->
      <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-6 rounded-3xl shadow-2xl text-center transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="200">
        <div class="w-24 h-24 bg-gradient-to-br from-[#fbbf24] to-[#fcd34d] rounded-full mx-auto mb-4 flex items-center justify-center">
          <span class="text-3xl font-bold text-gray-900">N</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Naila</h3>
        <p class="text-yellow-300 text-sm mb-3">AI Engineer</p>
        <p class="text-white/70 text-sm">Mengembangkan model AI untuk deteksi penyakit</p>
      </div>

      <!-- Team Member 3 -->
      <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-6 rounded-3xl shadow-2xl text-center transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="300">
        <div class="w-24 h-24 bg-gradient-to-br from-[#3a4a2a] to-[#4a5a3a] rounded-full mx-auto mb-4 flex items-center justify-center">
          <span class="text-3xl font-bold text-white">A</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Ahlan</h3>
        <p class="text-yellow-300 text-sm mb-3">AI Engineer</p>
        <p class="text-white/70 text-sm">Mengembangkan model AI untuk deteksi penyakit</p>
      </div>

      <!-- Team Member 4 -->
      <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-6 rounded-3xl shadow-2xl text-center transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="400">
        <div class="w-24 h-24 bg-gradient-to-br from-[#ff6b4a] to-[#ff8c6b] rounded-full mx-auto mb-4 flex items-center justify-center">
          <span class="text-3xl font-bold text-white">A</span>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Albab</h3>
        <p class="text-yellow-300 text-sm mb-3">Full Stack Developer</p>
        <p class="text-white/70 text-sm">Membangun platform web dan mobile app</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== CTA SECTION ===== -->
<section id="kontak" class="relative overflow-hidden" style="background-image: url('{{ asset('images/hero123.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 110vh;">
  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black/60"></div>
  
  <!-- Pattern background -->
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-20"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex items-center justify-center text-center" style="min-height: 110vh;">
    <div class="w-full" data-aos="fade-up">
      <h2 class="text-6xl md:text-7xl lg:text-8xl xl:text-9xl font-extrabold text-white mb-12 leading-tight">
        DIMULAI DARI KAMI,<br>
        <span class="bg-gradient-to-r from-[#10b981] via-[#34d399] to-[#10b981] bg-clip-text text-transparent">
          UNTUK ANDA.
        </span>
      </h2>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="https://wa.me/6285122983440?text={{ urlencode('Halo, saya tertarik untuk bergabung dengan Ganodetect') }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#10b981] to-[#34d399] text-white px-10 py-5 rounded-full font-bold text-lg hover:shadow-2xl hover:shadow-green-500/50 transition-all duration-300 transform hover:scale-105">
          Hubungi Kami
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
          </svg>
        </a>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur text-white border border-white/20 px-10 py-5 rounded-full font-bold text-lg hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
          Kembali ke Beranda
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Add AOS Animation Library -->
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100
  });
</script>

@endsection
