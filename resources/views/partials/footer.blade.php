{{-- resources/views/partials/footer.blade.php --}}

<footer class="text-[#F2E8CF]" style="background-color: #1E201E;">
  <div class="border-t border-white/10"></div>
  <div class="w-full max-w-none mx-auto px-4 sm:px-6 lg:px-10 xl:px-14 2xl:px-20 py-10">
    <div class="grid gap-10 md:grid-cols-3 items-start">
      <!-- Branding -->
      <div>
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/logo.png') }}" alt="Ganodetect" class="h-12 md:h-14 w-auto">
          <div class="leading-tight">
            <div class="font-extrabold text-2xl md:text-4xl tracking-tight">Ganodetect</div>
            <div class="text-sm opacity-90">ganodetect.com</div>
          </div>
        </div>
      </div>

      <!-- Address -->
      <div>
        <h4 class="font-extrabold text-xl md:text-2xl">SEKOLAH VOKASI IPB</h4>
        <address class="not-italic mt-3 text-sm md:text-base leading-relaxed">
          Jl. Kumbang No.14, RT.02/RW.06, Babakan, Kecamatan Bogor Tengah, Kota Bogor, Jawa Barat 16128.
        </address>
      </div>

      <!-- Socials -->
      <div class="md:justify-self-end md:text-right">
        <h4 class="font-semibold text-lg md:text-xl">Ikuti Kami</h4>
        <div class="mt-4 flex gap-3 md:justify-end">
          <a href="#" class="group size-10 rounded bg-white/10 grid place-items-center hover:bg-white/20 transition" aria-label="Facebook">
            <svg viewBox="0 0 24 24" class="w-5 h-5 text-[#F2E8CF]" fill="currentColor" aria-hidden="true"><path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.16 1.8.16v2h-1c-1 0-1.3.63-1.3 1.3V12h2.2l-.35 3h-1.85v7A10 10 0 0 0 22 12"/></svg>
          </a>
          <a href="#" class="group size-10 rounded bg-white/10 grid place-items-center hover:bg-white/20 transition" aria-label="Instagram">
            <svg viewBox="0 0 24 24" class="w-5 h-5 text-[#F2E8CF]" fill="currentColor" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7m5 3a5 5 0 1 1 0 10 5 5 0 0 1 0-10m0 2.2a2.8 2.8 0 1 0 0 5.6 2.8 2.8 0 0 0 0-5.6m5.25-.95a.95.95 0 1 1 0 1.9.95.95 0 0 1 0-1.9Z"/></svg>
          </a>
          <a href="#" class="group size-10 rounded bg-white/10 grid place-items-center hover:bg-white/20 transition" aria-label="YouTube">
            <svg viewBox="0 0 24 24" class="w-5 h-5 text-[#F2E8CF]" fill="currentColor" aria-hidden="true"><path d="M10 15l5.2-3L10 9v6m-6.5-8.1c.5-1.9 2-3.4 3.9-3.9C9.3 3 12 3 12 3s2.7 0 4.6.4c1.9.5 3.4 2 3.9 3.9C21 8.3 21 12 21 12s0 3.7-.5 5.6c-.5 1.9-2 3.4-3.9 3.9C14.7 22 12 22 12 22s-2.7 0-4.6-.4c-1.9-.5-3.4-2-3.9-3.9C3 15.7 3 12 3 12s0-3.7.5-5.6Z"/></svg>
          </a>
          <a href="#" class="group size-10 rounded bg-white/10 grid place-items-center hover:bg-white/20 transition" aria-label="X">
            <svg viewBox="0 0 24 24" class="w-5 h-5 text-[#F2E8CF]" fill="currentColor" aria-hidden="true"><path d="M17.53 3H20l-5.3 6.06L21 21h-6.56l-4.14-5.41L4.47 21H2l5.77-6.6L3 3h6.7l3.74 5.05L17.53 3Zm-2.3 16h1.7L8.86 5h-1.7l7.07 14Z"/></svg>
          </a>
        </div>
      </div>
    </div>

    <div class="border-t border-white/10 mt-4 pt-6 text-sm">© {{ date('Y') }} Ganodetect</div>
  </div>
  <div id="kontak" class="sr-only">Kontak</div>
</footer>
