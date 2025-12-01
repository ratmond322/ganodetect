{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
  <div class="min-h-screen bg-gradient-to-br from-[#1a2312] via-[#2d3a1f] to-[#3a4a28] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

      <div class="mb-8 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white">Masuk ke akun Anda</h1>
        <p class="text-gray-300 mt-2">Akses dashboard, order, dan fitur eksklusif Ganodetect.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- LOGIN FORM -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 shadow-xl border border-white/20">
          <x-auth-session-status class="mb-4" :status="session('status')" />

          <!-- show validation errors -->
          <x-auth-validation-errors class="mb-4" :errors="$errors" />

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
              <x-label for="email" :value="__('Email')" class="text-white font-semibold" />
              <x-input id="email" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-gray-300" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
              <x-label for="password" :value="__('Password')" class="text-white font-semibold" />
              <x-input id="password" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-gray-300" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-between mt-4">
              <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 rounded bg-white/20 border-white/30">
                <span class="text-sm text-white">Ingat saya</span>
              </label>

              @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-300 hover:text-white" href="{{ route('password.request') }}">
                  {{ __('Lupa password?') }}
                </a>
              @endif
            </div>

            <div class="flex flex-col gap-3 mt-6">
              <x-button class="w-full bg-gradient-to-r from-[#10b981] to-[#34d399] hover:from-[#059669] hover:to-[#10b981] text-white font-bold py-3">
                {{ __('Masuk') }}
              </x-button>

              <!-- Google OAuth button -->
              <a href="{{ route('auth.google.redirect') }}"
                 class="w-full inline-flex items-center justify-center gap-3 px-4 py-3 bg-white border border-gray-300 rounded-lg shadow hover:shadow-lg text-sm text-gray-700 font-medium transition">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="h-5 w-5" />
                <span>Masuk dengan Google</span>
              </a>
            </div>
          </form>

          <p class="mt-6 text-sm text-gray-200 text-center">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#34d399] font-semibold hover:underline">Daftar sekarang</a>
          </p>
        </div>

        <!-- RIGHT: info -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 shadow-xl border border-white/20 flex flex-col justify-between">
          <div>
            <h3 class="text-lg font-semibold text-white mb-4">Kenapa daftar?</h3>
            <ul class="space-y-2 text-gray-200">
              <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-[#34d399] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Akses produk & dokumentasi</span>
              </li>
              <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-[#34d399] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Order langsung & tracking</span>
              </li>
              <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-[#34d399] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Support teknis prioritas</span>
              </li>
            </ul>
          </div>

          <div class="mt-6">
            <p class="text-sm text-gray-300 mb-3">Atau hubungi kami langsung untuk pertanyaan cepat.</p>
            <a href="https://wa.me/6285122983440" target="_blank" class="inline-flex items-center justify-center gap-2 w-full px-4 py-3 rounded-lg bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold hover:from-green-500 hover:to-green-400 transition">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
              </svg>
              Hubungi via WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
      </div>
    </div>
  </div>
</x-guest-layout>
