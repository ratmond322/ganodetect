@extends('layouts.guest')

@section('content')
<section class="bg-brandLight min-h-screen py-20">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

      <!-- LEFT: PRODUCT IMAGE -->
      <div>
        <img src="{{ asset('images/' . $product['images'][0]) }}"
             class="w-full rounded-xl shadow-lg object-cover">

        <!-- thumbnails if you want -->
        <div class="grid grid-cols-5 gap-2 mt-4">
          @foreach($product['images'] as $img)
            <img src="{{ asset('images/' . $img) }}"
                 class="h-20 w-full object-cover rounded-md border border-gray-300">
          @endforeach
        </div>
      </div>

      <!-- RIGHT: SPECIFICATIONS -->
      <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <h1 class="text-4xl font-bold mb-4 tracking-widest">{{ $product['name'] }}</h1>

        <p class="text-gray-600 leading-relaxed mb-6">
          {{ $product['special_feature'] }}
        </p>

        <!-- Price section -->
        <p class="text-red-600 font-bold text-lg mb-1">-20% IDR {{ $product['price'] }}</p>
        <p class="line-through text-gray-400 text-sm mb-6">Typical price: {{ $product['price_original'] }}</p>

        <div class="grid grid-cols-1 gap-4 text-sm">

          <div><strong>Brand:</strong> {{ $product['brand'] }}</div>
          <div><strong>Model Name:</strong> {{ $product['model_name'] }}</div>
          <div><strong>Special Feature:</strong><br> {{ $product['special_feature'] }}</div>

          <div><strong>Age Range (Description):</strong> {{ $product['age_range'] }}</div>
          <div><strong>Color:</strong> {{ $product['color'] }}</div>
          <div><strong>Photo Resolution:</strong> {{ $product['photo_resolution'] }}</div>
          <div><strong>Capture:</strong> {{ $product['capture'] }}</div>

          <div><strong>Connectivity Technology:</strong> {{ $product['connectivity'] }}</div>

          <div><strong>Included Components:</strong><br>
            {{ $product['included_components'] }}
          </div>

          <div><strong>Skill Level:</strong> {{ $product['skill_level'] }}</div>
          <div><strong>Item Weight:</strong> {{ $product['item_weight'] }}</div>

        </div>

        <div class="mt-8">
          <button class="w-full bg-brandOlive text-white font-semibold py-3 rounded-lg hover:bg-brandOlive/80 transition">
            Add to cart
          </button>
        </div>

      </div>

    </div>

  </div>
</section>
@endsection
