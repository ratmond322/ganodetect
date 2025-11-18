{{-- resources/views/components/auth-validation-errors.blade.php --}}
@props(['errors'])

@if ($errors && $errors->any())
  <div {{ $attributes->merge(['class' => 'mb-4 rounded-md bg-red-50 border border-red-100 text-red-800 px-4 py-3']) }}>
    <div class="font-medium">Whoops! Ada masalah input.</div>
    <ul class="mt-2 list-disc list-inside text-sm">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
