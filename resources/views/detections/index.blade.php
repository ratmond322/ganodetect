@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-[#1E201E] p-6">

    <h1 class="text-3xl text-white font-bold mb-4">Semua Hasil Deteksi</h1>

    @if(session('success'))
        <div class="p-3 bg-green-600 text-white rounded mb-4">{{ session('success') }}</div>
    @endif

    @if($detections->count() == 0)
        <p class="text-white/70">Belum ada deteksi.</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($detections as $d)
        <div class="bg-[#151515] p-4 rounded-xl border border-white/10 shadow">
            
            <img src="{{ $d->annotated_path ? asset('storage/' . $d->annotated_path) : asset('storage/' . $d->image_path) }}"
                 class="w-full h-40 object-cover rounded-lg mb-3">

            <h2 class="text-lg font-semibold text-white mb-1">
                Deteksi #{{ $d->id }}
            </h2>

            <p class="text-white/70 text-sm">
                {{ $d->total_detected ?? 0 }} objek •
                {{ $d->infected_count ?? 0 }} terinfeksi •
                {{ $d->healthy_count ?? 0 }} sehat
            </p>

            <p class="text-white/50 text-xs mt-1">
                {{ $d->created_at->diffForHumans() }}
            </p>

            <div class="flex justify-between mt-4">
                <a href="{{ route('detections.show', $d->id) }}"
                   class="px-3 py-1 bg-[#7c8d34] text-white rounded hover:bg-[#6a7a2a] text-sm">Detail</a>

                <form method="POST" action="{{ route('detections.destroy', $d->id) }}"
                      onsubmit="return confirm('Yakin ingin menghapus deteksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded text-sm">Hapus</button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $detections->links() }}
    </div>

</div>
@endsection
