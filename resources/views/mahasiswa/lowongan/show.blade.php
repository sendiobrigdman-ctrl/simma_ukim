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

        <div class="mt-6">
            <a href="{{ route('mahasiswa.lowongan.index') }}" class="text-gray-600">&larr; Kembali</a>

            <form action="{{ route('mahasiswa.lowongan.apply', $lowongan) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Upload CV (PDF/DOC/DOCX) <span class="text-red-600">*</span></label>
                    <input type="file" name="cv" accept=".pdf,.doc,.docx" required class="mt-1 block w-full" />
                    @error('cv')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ajukan Lamaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
