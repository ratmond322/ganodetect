{{-- Global Header: ditampilkan di semua halaman guest melalui layouts.guest --}}
<header id="site-header" role="banner" aria-label="Site header" class="fixed inset-x-0 top-0 z-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="h-20 md:h-24 flex items-center justify-between relative">
			<a href="{{ url('/') }}" class="flex items-center z-10">
				<img src="{{ asset('images/logo.png') }}" alt="Ganodetect Logo" class="h-14 sm:h-16 md:h-20 lg:h-24 w-auto" style="filter: drop-shadow(0 2px 6px rgba(0,0,0,0.25));">
			</a>
			<nav class="hidden md:flex items-center space-x-8 text-white font-semibold text-base md:text-lg lg:text-xl absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 whitespace-nowrap" aria-label="Primary">
				<a href="{{ url('/') }}" class="hover:text-yellow-300 {{ request()->is('/') ? 'opacity-100' : 'opacity-80' }}">Beranda</a>
				<a href="{{ route('tentang') }}" class="hover:text-yellow-300 {{ request()->is('tentang') ? 'opacity-100' : 'opacity-80' }}">Tentang</a>
				<a href="{{ route('products.index') }}" class="hover:text-yellow-300 {{ request()->is('products') ? 'opacity-100' : 'opacity-80' }}">Produk</a>
				<a href="{{ route('articles.index') }}" class="hover:text-yellow-300 {{ request()->is('artikel') ? 'opacity-100' : 'opacity-80' }}">Artikel</a>
				<a href="{{ url('/#testimonials-section') }}" class="hover:text-yellow-300 opacity-80">Testimoni</a>
				<a href="{{ url('/tentang#kontak') }}" class="hover:text-yellow-300 opacity-80 whitespace-nowrap">Contact Us</a>
			</nav>
			<div class="flex items-center gap-4 z-10">
				@auth
					<div class="relative" x-data="{ open: false }">
						<button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none group">
							<img src="{{ Auth::user()->avatar_url }}?t={{ Auth::user()->updated_at?->timestamp ?? time() }}" alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover border border-white/30 ring-2 ring-white/20 group-hover:ring-yellow-300 transition">
							<svg class="w-4 h-4 text-white group-hover:text-yellow-300 transition" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
							</svg>
						</button>
						<div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50">
							<div class="px-4 py-2 border-b border-gray-100">
								<p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
								<p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
							</div>
							@if(Auth::user()->is_admin)
								<a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
								</a>
							@else
								<a href="{{ route('dashboard.admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<i class="fas fa-home mr-2"></i>Dashboard
								</a>
							@endif
							<a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
								<i class="fas fa-user mr-2"></i>Profile
							</a>
							<hr class="my-1">
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
									<i class="fas fa-sign-out-alt mr-2"></i>Logout
								</button>
							</form>
						</div>
					</div>
				@endauth
				@guest
					<a href="{{ route('login') }}" class="text-white font-semibold hover:text-yellow-300 transition">Masuk</a>
					<a href="{{ route('register') }}" class="px-4 py-2 rounded-full bg-darkTeal/70 backdrop-blur-sm text-white text-sm font-semibold hover:bg-darkTeal transition">Daftar</a>
				@endguest
				<button id="menu-btn" class="md:hidden p-2 rounded-md bg-black/25 text-white" aria-expanded="false" aria-label="Buka menu">☰</button>
			</div>
		</div>
	</div>
	<div id="mobile-menu" class="hidden md:hidden bg-black/60 backdrop-blur-sm text-white">
		<div class="px-4 py-4 space-y-2 max-w-7xl mx-auto">
			<a href="{{ url('/') }}" class="block text-lg">Beranda</a>
			<a href="{{ route('tentang') }}" class="block text-lg">Tentang</a>
			<a href="{{ route('products.index') }}" class="block text-lg">Produk</a>
			<a href="{{ route('articles.index') }}" class="block text-lg">Artikel</a>
			<a href="{{ url('/#testimonials-section') }}" class="block text-lg">Testimoni</a>
			<a href="{{ url('/tentang#kontak') }}" class="block text-lg">Kontak</a>
			@guest
				<div class="pt-2 border-t border-white/20"></div>
				<a href="{{ route('login') }}" class="block text-lg font-semibold">Masuk</a>
				<a href="{{ route('register') }}" class="block text-lg font-semibold">Daftar</a>
			@endguest
			@auth
				<div class="pt-2 border-t border-white/20 text-sm">Login sebagai {{ Auth::user()->name }}</div>
			@endauth
		</div>
	</div>
	<script>
		(function () {
			const btn = document.getElementById('menu-btn');
			const menu = document.getElementById('mobile-menu');
			if (!btn || !menu) return;
			btn.addEventListener('click', () => {
				menu.classList.toggle('hidden');
				btn.setAttribute('aria-expanded', String(!menu.classList.contains('hidden')));
			});
		})();
	</script>
</header>
