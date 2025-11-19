@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-6">Beri Nilai untuk {{ $aplikasi->user->name ?? 'Mahasiswa' }}</h1>

    <div class="bg-white shadow rounded p-4">
        <form method="POST" action="{{ route('mitra.penilaian.store', $aplikasi) }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Nilai Disiplin (0-100)</label>
                <input type="number" name="nilai_disiplin" min="0" max="100" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nilai_disiplin') }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Nilai Kerja (0-100)</label>
                <input type="number" name="nilai_kerja" min="0" max="100" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nilai_kerja') }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Catatan (opsional)</label>
                <textarea name="catatan" class="mt-1 block w-full border rounded px-3 py-2" rows="4">{{ old('catatan') }}</textarea>
            </div>

            <div>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan Penilaian</button>
                <a href="{{ route('mitra.penilaian.index') }}" class="ms-2 text-gray-600">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
