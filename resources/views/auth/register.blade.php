{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
  <div class="max-w-4xl mx-auto px-6 pt-24 pb-12">

    <div class="mb-8 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Daftar Akun Customer</h1>
      <p class="text-gray-700 mt-2">Masukkan token yang diberikan admin untuk mengakses dashboard.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- REGISTRATION FORM -->
      <div class="bg-white rounded-xl p-8 shadow">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- show validation errors -->
        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
          <ul class="list-disc list-inside text-sm text-red-600">
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
            <x-label for="token" value="Token Customer" />
            <x-input id="token" class="block mt-1 w-full" type="text" name="token" :value="old('token')" required autofocus placeholder="Masukkan token dari admin" />
            <p class="text-xs text-gray-500 mt-1">Token didapat dari admin setelah pembelian drone</p>
          </div>

          <!-- Name -->
          <div class="mt-4">
            <x-label for="name" value="Nama Lengkap" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
          </div>

          <!-- Email -->
          <div class="mt-4">
            <x-label for="email" value="Email" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
          </div>

          <!-- Password -->
          <div class="mt-4">
            <x-label for="password" value="Password" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
          </div>

          <!-- Confirm Password -->
          <div class="mt-4">
            <x-label for="password_confirmation" value="Konfirmasi Password" />
            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
          </div>

          <div class="flex items-center gap-3 mt-6">
            <x-button class="bg-brandOlive">
              Daftar
            </x-button>
          </div>
        </form>

        <p class="mt-6 text-sm text-gray-600">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="text-brandOlive font-semibold hover:underline">Masuk sekarang</a>
        </p>
      </div>

      <!-- RIGHT: info -->
      <div class="bg-white rounded-xl p-8 shadow flex flex-col justify-between">
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Cara Mendapatkan Token</h3>
          <ol class="list-decimal ml-5 text-gray-700 space-y-2">
            <li>Hubungi admin via WhatsApp untuk pembelian drone</li>
            <li>Setelah transaksi, admin akan memberikan token unik</li>
            <li>Gunakan token tersebut untuk registrasi akun</li>
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
