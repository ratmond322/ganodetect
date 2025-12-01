@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-[#1E201E] p-6">

    <a href="{{ route('detections.index') }}"
       class="text-[#7c8d34] hover:underline">&larr; Kembali</a>

    <h1 class="text-3xl text-white font-bold mt-3">Deteksi #{{ $detection->id }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        <div>
            <img src="{{ $detection->annotated_path ? asset('storage/'.$detection->annotated_path) : asset('storage/'.$detection->image_path) }}"
                 class="rounded-xl border border-white/10 shadow">
        </div>

        <div class="bg-[#151515] p-6 rounded-xl border border-white/10">

            <p class="text-white/80 text-sm mb-2">
                Total objek: <strong>{{ $detection->total_detected }}</strong>
            </p>

            <p class="text-white/80 text-sm mb-4">
                Terinfeksi: <strong>{{ $detection->infected_count }}</strong>  
                • Sehat: <strong>{{ $detection->healthy_count }}</strong>
            </p>

            <h3 class="text-white font-semibold mb-3">Prediksi:</h3>

            @if(count($predictions) == 0)
                <p class="text-white/50">Tidak ada prediksi.</p>
            @endif

            <ul class="list-disc pl-6 text-white/70 space-y-1">
                @foreach($predictions as $p)
                <li>
                    <strong>{{ $p['label'] }}</strong> —
                    {{ round(($p['confidence'] ?? 0) * 100, 1) }}%
                    <span class="text-white/40 text-sm">
                        bbox: {{ implode(',', $p['bbox'] ?? []) }}
                    </span>
                </li>
                @endforeach
            </ul>

        </div>

    </div>

</div>
@endsection
