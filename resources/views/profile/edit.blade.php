@extends('layouts.guest')

@section('content')
<div class="min-h-screen" style="background-color: #1E201E;">
  <!-- Header -->
  <div class="border-b border-white/10" style="background-color: #151715;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-white">Edit Profile</h1>
          <p class="text-white/60 mt-1">Update informasi akun Anda</p>
        </div>
        <div class="flex items-center gap-4">
          <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard.admin') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition">
            ← Kembali ke Dashboard
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if(session('status'))
    <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4 mb-6">
      <p class="text-white font-semibold">{{ session('status') }}</p>
    </div>
    @endif

    <!-- Profile Photo Section -->
    <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5 mb-6">
      <h3 class="text-xl font-semibold text-white mb-4">Foto Profile</h3>
      
      <div class="flex items-center gap-6">
        <div class="relative">
          @if(Auth::user()->profile_photo)
            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-[#7c8d34]">
          @else
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#7c8d34] to-[#6a7a2a] flex items-center justify-center border-4 border-[#7c8d34]">
              <span class="text-3xl font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
          @endif
        </div>

        <form method="POST" action="{{ route('profile.update.photo') }}" enctype="multipart/form-data" class="flex-1">
          @csrf
          @method('PATCH')
          
          <div>
            <label class="block text-white/80 text-sm mb-2">Upload Foto Baru</label>
            <input type="file" name="profile_photo" accept="image/*" class="block w-full text-sm text-white/80 
              file:mr-4 file:py-2 file:px-4 
              file:rounded-lg file:border-0 
              file:text-sm file:font-semibold 
              file:bg-[#7c8d34] file:text-white 
              hover:file:bg-[#6a7a2a] file:cursor-pointer">
            @error('profile_photo')
              <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <button type="submit" class="mt-3 px-4 py-2 bg-gradient-to-r from-[#7c8d34] to-[#6a7a2a] hover:from-[#6a7a2a] hover:to-[#7c8d34] text-white font-semibold rounded-lg transition">
            Update Foto
          </button>
        </form>
      </div>
    </div>

    <!-- Update Profile Information -->
    <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5 mb-6">
      <h3 class="text-xl font-semibold text-white mb-4">Informasi Profile</h3>
      
      <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="mb-4">
          <label for="name" class="block text-white/80 text-sm font-medium mb-2">Nama Lengkap</label>
          <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" 
            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-[#7c8d34] focus:border-transparent"
            required>
          @error('name')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="block text-white/80 text-sm font-medium mb-2">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-[#7c8d34] focus:border-transparent"
            required>
          @error('email')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#7c8d34] to-[#6a7a2a] hover:from-[#6a7a2a] hover:to-[#7c8d34] text-white font-semibold rounded-lg transition">
          Update Informasi
        </button>
      </form>
    </div>

    <!-- Update Password -->
    <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5 mb-6">
      <h3 class="text-xl font-semibold text-white mb-4">Ubah Password</h3>
      
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div class="mb-4">
          <label for="current_password" class="block text-white/80 text-sm font-medium mb-2">Password Saat Ini</label>
          <input type="password" id="current_password" name="current_password" 
            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-[#7c8d34] focus:border-transparent"
            required autocomplete="current-password">
          @error('current_password', 'updatePassword')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- New Password -->
        <div class="mb-4">
          <label for="password" class="block text-white/80 text-sm font-medium mb-2">Password Baru</label>
          <input type="password" id="password" name="password" 
            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-[#7c8d34] focus:border-transparent"
            required autocomplete="new-password">
          @error('password', 'updatePassword')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
          <label for="password_confirmation" class="block text-white/80 text-sm font-medium mb-2">Konfirmasi Password Baru</label>
          <input type="password" id="password_confirmation" name="password_confirmation" 
            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-[#7c8d34] focus:border-transparent"
            required autocomplete="new-password">
          @error('password_confirmation', 'updatePassword')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#7c8d34] to-[#6a7a2a] hover:from-[#6a7a2a] hover:to-[#7c8d34] text-white font-semibold rounded-lg transition">
          Update Password
        </button>
      </form>
    </div>

  </div>
</div>
@endsection
