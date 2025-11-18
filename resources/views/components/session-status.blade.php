@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 rounded-md bg-green-50 border border-green-100 p-4 text-sm text-green-700']) }}>
        {{ $status }}
    </div>
@endif
