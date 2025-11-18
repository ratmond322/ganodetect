@extends('layouts.guest')

@section('content')
<div class="min-h-screen" style="background-color: #1E201E;">
  <!-- Header -->
  <div class="border-b border-white/10" style="background-color: #151715;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
          <p class="text-white/60 mt-1">Kelola Token, Artikel & Customer</p>
        </div>
        <div class="flex items-center gap-4">
          <!-- User Dropdown -->
          <div class="relative">
            <button data-dropdown-toggle="adminUserDropdown" class="flex items-center gap-3 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition cursor-pointer">
              @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-[#7c8d34]">
              @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#7c8d34] to-[#6a7a2a] flex items-center justify-center border-2 border-[#7c8d34]">
                  <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
              @endif
              <span class="text-white/80">{{ Auth::user()->name }}</span>
              <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="adminUserDropdown" data-dropdown-menu class="hidden absolute right-0 mt-2 w-56 bg-[#151715] border border-white/10 rounded-lg shadow-xl overflow-hidden z-50">
              <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-white/80 hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                  </svg>
                  <span>Dashboard</span>
                </div>
              </a>
              <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-white/80 hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  <span>Edit Profile</span>
                </div>
              </a>
              <div class="border-t border-white/10"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 text-red-400 hover:bg-white/10 transition">
                  <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                  </div>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Token Generator Section -->
    <div class="bg-gradient-to-r from-[#7c8d34] to-[#6a7a2a] p-6 rounded-xl shadow-lg mb-8 border border-white/10">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h3 class="text-2xl font-bold text-white">Token Generator</h3>
          <p class="text-white/80 text-sm mt-1">Generate token untuk customer baru yang beli drone via WhatsApp</p>
        </div>
        <form method="POST" action="{{ route('tokens.generate') }}">
          @csrf
          <button type="submit" class="px-6 py-3 bg-white hover:bg-white/90 text-[#7c8d34] font-semibold rounded-lg transition shadow-lg">
            Generate Token Baru
          </button>
        </form>
      </div>

      @if(session('success'))
      <div class="bg-white/20 border border-white/30 rounded-lg p-4 mb-4">
        <p class="text-white font-bold text-lg">{{ session('success') }}</p>
        <p class="text-white/70 text-sm mt-1">Kirim token ini ke customer via WhatsApp untuk registrasi</p>
      </div>
      @endif

      @if($errors->any())
      <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 mb-4">
        <p class="text-white font-bold">{{ $errors->first() }}</p>
      </div>
      @endif

      <!-- Active Tokens List -->
      <div class="bg-white/10 rounded-lg p-4">
        <h4 class="text-white font-semibold mb-3">Token Aktif (Belum Digunakan) - {{ $activeTokens->count() }} token</h4>
        <div class="space-y-2 max-h-96 overflow-y-auto">
          @forelse($activeTokens as $token)
          <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg hover:bg-white/10 transition">
            <div>
              <code class="text-white font-mono text-lg font-bold">{{ $token->token }}</code>
              <p class="text-white/60 text-xs mt-1">Dibuat: {{ $token->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex gap-2">
              <button onclick="copyToken('{{ $token->token }}')" class="px-3 py-1 bg-white/20 hover:bg-white/30 text-white text-sm rounded transition">
                Copy
              </button>
              <form method="POST" action="{{ route('tokens.destroy', $token->id) }}" class="inline" onsubmit="return confirm('Yakin hapus token ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 bg-red-500/20 hover:bg-red-500/30 text-white text-sm rounded transition">
                  Hapus
                </button>
              </form>
            </div>
          </div>
          @empty
          <p class="text-white/60 text-sm">Belum ada token yang tersedia. Generate token baru untuk customer.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Card 1: Articles -->
      <div class="bg-gradient-to-br from-[#7c8d34] to-[#6a7a2a] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-white/80 text-sm font-medium">Total Artikel</p>
            <p class="text-3xl font-bold text-white mt-2">{{ $articlesCount }}</p>
            <p class="text-xs text-white/60 mt-1">Published articles</p>
          </div>
          <div class="text-4xl opacity-20">📝</div>
        </div>
      </div>

      <!-- Card 2: Total Tokens -->
      <div class="bg-gradient-to-br from-[#fbbf24] to-[#f59e0b] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-900/80 text-sm font-medium">Total Token</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTokens }}</p>
            <p class="text-xs text-gray-900/60 mt-1">{{ $usedTokens }} sudah digunakan</p>
          </div>
          <div class="text-4xl opacity-20">🎫</div>
        </div>
      </div>

      <!-- Card 3: Active Tokens -->
      <div class="bg-gradient-to-br from-[#10b981] to-[#059669] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-white/80 text-sm font-medium">Token Aktif</p>
            <p class="text-3xl font-bold text-white mt-2">{{ $activeTokens->count() }}</p>
            <p class="text-xs text-white/60 mt-1">Siap digunakan</p>
          </div>
          <div class="text-4xl opacity-20">✅</div>
        </div>
      </div>

      <!-- Card 4: Customers -->
      <div class="bg-gradient-to-br from-[#3b82f6] to-[#2563eb] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-white/80 text-sm font-medium">Total Customer</p>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalCustomers }}</p>
            <p class="text-xs text-white/60 mt-1">Registered customers</p>
          </div>
          <div class="text-4xl opacity-20">👥</div>
        </div>
      </div>
    </div>

    <!-- Recent Articles & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Recent Articles -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Recent Articles</h3>
        <div class="space-y-3">
          @forelse($recentArticles as $article)
          <div class="p-3 bg-white/5 rounded-lg hover:bg-white/10 transition">
            <h4 class="text-white font-semibold">{{ $article->title }}</h4>
            <p class="text-white/60 text-sm mt-1">{{ Str::limit($article->excerpt, 80) }}</p>
            <p class="text-white/40 text-xs mt-2">{{ $article->created_at->format('d M Y') }}</p>
          </div>
          @empty
          <p class="text-white/60 text-sm">Belum ada artikel.</p>
          @endforelse
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Quick Actions</h3>
        <div class="space-y-3">
          <a href="{{ route('admin.articles.create') }}" class="block w-full px-4 py-3 bg-gradient-to-r from-[#7c8d34] to-[#6a7a2a] hover:from-[#6a7a2a] hover:to-[#7c8d34] text-white font-semibold rounded-lg transition text-center">
            ➕ Create New Article
          </a>
          <a href="{{ route('admin.articles.index') }}" class="block w-full px-4 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg transition text-center">
            📋 Manage Articles
          </a>
          <a href="{{ route('home') }}" class="block w-full px-4 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg transition text-center">
            🏠 View Main Site
          </a>
        </div>

        <div class="mt-6 p-4 bg-white/5 rounded-lg">
          <h4 class="text-white font-semibold text-sm mb-2">Tips:</h4>
          <ul class="text-white/70 text-xs space-y-1">
            <li>• Generate token setelah customer konfirmasi pembelian via WhatsApp</li>
            <li>• Kirim token langsung ke customer untuk registrasi</li>
            <li>• Token hanya bisa digunakan sekali</li>
            <li>• Hapus token yang tidak jadi digunakan</li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
window.copyToken = function(token) {
  navigator.clipboard.writeText(token).then(() => {
    alert('Token berhasil dicopy: ' + token + '\n\nKirim ke customer via WhatsApp.');
  }).catch(() => {
    prompt('Copy token berikut:', token);
  });
};

// User Dropdown Handler
document.addEventListener('DOMContentLoaded', function() {
  const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
  
  dropdownButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.stopPropagation();
      const dropdownId = this.getAttribute('data-dropdown-toggle');
      const dropdown = document.getElementById(dropdownId);
      
      if (dropdown) {
        dropdown.classList.toggle('hidden');
      }
    });
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function() {
    document.querySelectorAll('[data-dropdown-menu]').forEach(dropdown => {
      dropdown.classList.add('hidden');
    });
  });
});
</script>
@endsection
