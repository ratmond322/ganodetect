@extends('layouts.app')

@section('content')
	<div class="max-w-7xl mx-auto py-10 px-4">
		<div class="bg-white shadow rounded-lg p-6">
			<h2 class="text-2xl font-semibold mb-2">Dashboard</h2>
			<p class="text-sm text-gray-600 mb-4">Selamat datang! Anda berhasil masuk.</p>

			@auth
				@if(auth()->user()->is_admin ?? false)
					<div class="alert alert-info mb-4">Anda adalah admin — kunjungi <a href="{{ route('admin.dashboard') }}" class="underline">Admin Dashboard</a>.</div>
				@else
					<p class="text-gray-700">Ini adalah area pengguna. Untuk mengelola konten, hubungi administrator.</p>
				@endif
			@endauth

		</div>
	</div>
@endsection
