{{-- resources/views/components/input.blade.php --}}
@props([
  'type' => 'text',
  'name' => '',
  'value' => '',
  'id' => null,
])

@php
  $idAttr = $id ?? $name;
@endphp

<input
  id="{{ $idAttr }}"
  name="{{ $name }}"
  type="{{ $type }}"
  value="{{ old($name, $value) }}"
  {{ $attributes->merge(['class' => 'border-gray-200 block w-full rounded-md shadow-sm focus:ring-2 focus:ring-brandOlive focus:border-brandOlive']) }}
/>
