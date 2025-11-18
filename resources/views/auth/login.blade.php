{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
  <div class="max-w-4xl mx-auto px-6 pt-24 pb-12">

    <div class="mb-8 text-center">
      <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">Masuk ke akun Anda</h1>
      <p class="text-gray-700 mt-2">Akses dashboard, order, dan fitur eksklusif Ganodetect.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- LOGIN FORM -->
      <div class="bg-white rounded-xl p-8 shadow">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- show validation errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <!-- Email -->
          <div>
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
          </div>

          <!-- Password -->
          <div class="mt-4">
            <x-label for="password" :value="__('Password')" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
          </div>

          <div class="flex items-center justify-between mt-4">
            <label class="flex items-center gap-2">
              <input type="checkbox" name="remember" class="form-checkbox h-4 w-4">
              <span class="text-sm">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
              <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                {{ __('Lupa password?') }}
              </a>
            @endif
          </div>

          <div class="flex items-center gap-3 mt-6">
            <x-button class="bg-brandOlive">
              {{ __('Masuk') }}
            </x-button>

            <!-- Google OAuth button -->
            <a href="{{ route('auth.google.redirect') }}"
               class="inline-flex items-center gap-3 px-4 py-2 bg-white border rounded shadow hover:shadow-md text-sm text-gray-700">
              <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="h-5 w-5" />
              <span>Masuk dengan Google</span>
            </a>
          </div>
        </form>

        <p class="mt-6 text-sm text-gray-600">
          Belum punya akun?
          <a href="{{ route('register') }}" class="text-brandOlive font-semibold hover:underline">Daftar sekarang</a>
        </p>
      </div>

      <!-- RIGHT: info -->
      <div class="bg-white rounded-xl p-8 shadow flex flex-col justify-between">
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Kenapa daftar?</h3>
          <ul class="list-disc ml-5 text-gray-700">
            <li>Akses produk & dokumentasi</li>
            <li>Order langsung & tracking</li>
            <li>Support teknis prioritas</li>
          </ul>
        </div>

        <div class="mt-6">
          <p class="text-sm text-gray-600">Atau hubungi kami langsung untuk pertanyaan cepat.</p>
          <a href="https://wa.me/6281234567890" target="_blank" class="mt-3 inline-block px-4 py-2 rounded-full bg-green-600 text-white">Hubungi via WhatsApp</a>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
