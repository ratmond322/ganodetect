{{-- resources/views/components/button.blade.php --}}
@props(['type' => 'submit'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 bg-brandOlive text-white rounded-md shadow hover:bg-[#588a2e] transition']) }}>
  {{ $slot }}
</button>
