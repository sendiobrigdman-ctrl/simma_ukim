@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-6">Lowongan Tersedia</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lowongans as $lowongan)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4">
                    <h2 class="text-lg font-bold mb-2">{{ $lowongan->title }}</h2>
                    @if(isset($lowongan->position))
                        <div class="text-sm text-gray-600 mb-2">Posisi: {{ $lowongan->position }}</div>
                    @endif
                    @if(isset($lowongan->location))
                        <div class="text-sm text-gray-600 mb-2">Lokasi: {{ $lowongan->location }}</div>
                    @endif
                    <p class="text-sm text-gray-700 truncate">{{ Str::limit($lowongan->description ?? '', 120) }}</p>
                </div>
                <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                    <a href="{{ route('mahasiswa.lowongan.show', $lowongan) }}" class="text-indigo-600 hover:underline">Lihat detail</a>
                    <a href="{{ route('mahasiswa.lowongan.show', $lowongan) }}" class="bg-indigo-600 text-white px-3 py-1 rounded">Ajukan Lamaran</a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">Tidak ada lowongan tersedia.</div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $lowongans->links() }}
    </div>
</div>
@endsection
