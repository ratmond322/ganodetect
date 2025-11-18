{{-- resources/views/components/guest-layout.blade.php --}}
@props([])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Ganodetect') }}</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Vite: pastikan css & js benar -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-inter bg-brandLight text-gray-800 antialiased min-h-screen">

  {{-- include header partial --}}
  @include('partials.header')

  <main class="min-h-[60vh]">
    {{ $slot }}
  </main>

  {{-- include footer partial --}}
  @include('partials.footer')

</body>
</html>
