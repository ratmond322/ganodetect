{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
  <div class="min-h-screen bg-gradient-to-br from-[#1a2312] via-[#2d3a1f] to-[#3a4a28] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

      <div class="mb-8 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Daftar Akun Customer</h1>
        <p class="text-gray-300 mt-2">Masukkan token yang diberikan admin untuk mengakses dashboard.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- REGISTRATION FORM -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 shadow-xl border border-white/20">
          <x-auth-session-status class="mb-4" :status="session('status')" />

          <!-- show validation errors -->
          @if ($errors->any())
          <div class="mb-4 p-4 bg-red-500/20 border border-red-400/30 rounded-lg backdrop-blur">
            <ul class="list-disc list-inside text-sm text-red-200">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Token -->
            <div>
              <x-label for="token" value="Token Customer" class="text-white font-semibold" />
              <x-input id="token" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-gray-300" type="text" name="token" :value="old('token')" required autofocus placeholder="Masukkan token dari admin" />
              <p class="text-xs text-gray-300 mt-1">Token didapat dari admin setelah pembelian drone</p>
            </div>

            <!-- Name -->
            <div class="mt-4">
              <x-label for="name" value="Nama Lengkap" class="text-white font-semibold" />
              <x-input id="name" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-gray-300" type="text" name="name" :value="old('name')" required />
            </div>

            <!-- Email -->
            <div class="mt-4">
              <x-label for="email" value="Email" class="text-white font-semibold" />
              <x-input id="email" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-gray-300" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
              <x-label for="password" value="Password" class="text-white font-semibold" />
              <x-input id="password" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-gray-300" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
              <x-label for="password_confirmation" value="Konfirmasi Password" class="text-white font-semibold" />
              <x-input id="password_confirmation" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-gray-300" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center gap-3 mt-6">
              <x-button class="w-full bg-gradient-to-r from-[#10b981] to-[#34d399] hover:from-[#059669] hover:to-[#10b981] text-white font-bold py-3">
                Daftar
              </x-button>
            </div>
          </form>

          <p class="mt-6 text-sm text-gray-200 text-center">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#34d399] font-semibold hover:underline">Masuk sekarang</a>
          </p>
        </div>

        <!-- RIGHT: info -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 shadow-xl border border-white/20 flex flex-col justify-between">
          <div>
            <h3 class="text-lg font-semibold text-white mb-4">Cara Mendapatkan Token</h3>
            <ol class="space-y-3 text-gray-200">
              <li class="flex items-start gap-2">
                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#34d399] text-[#1a2312] flex items-center justify-center text-sm font-bold">1</span>
                <span>Hubungi admin via WhatsApp untuk pembelian drone</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#34d399] text-[#1a2312] flex items-center justify-center text-sm font-bold">2</span>
                <span>Setelah transaksi, admin akan memberikan token unik</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#34d399] text-[#1a2312] flex items-center justify-center text-sm font-bold">3</span>
                <span>Gunakan token tersebut untuk registrasi akun</span>
              </li>
            <li>Akses dashboard customer untuk monitoring drone</li>
          </ol>
        </div>

        <div class="mt-6">
          <p class="text-sm text-gray-600 mb-3">Belum punya token? Hubungi kami untuk pembelian.</p>
          <a href="https://wa.me/6281234567890" target="_blank" class="inline-block px-4 py-2 rounded-full bg-green-600 text-white hover:bg-green-700 transition">
            Hubungi via WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
