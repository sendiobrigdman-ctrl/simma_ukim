@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-2">{{ $lowongan->title }}</h1>

        @if(isset($lowongan->position))
            <div class="text-sm text-gray-600 mb-1">Posisi: {{ $lowongan->position }}</div>
        @endif
        @if(isset($lowongan->location))
            <div class="text-sm text-gray-600 mb-1">Lokasi: {{ $lowongan->location }}</div>
        @endif

        <div class="mt-4 text-gray-700 whitespace-pre-line">
            {{ $lowongan->description ?? 'Deskripsi belum tersedia.' }}
        </div>

        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('mahasiswa.lowongan.index') }}" class="text-gray-600">&larr; Kembali</a>

            <form action="{{ route('mahasiswa.lowongan.apply', $lowongan) }}" method="POST">
                @csrf
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajukan Lamaran</button>
            </form>
        </div>
    </div>
</div>
@endsection
