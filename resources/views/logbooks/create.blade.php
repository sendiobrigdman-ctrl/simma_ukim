@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Tambah Entri Buku Harian</h1>

    @if ($errors->any())
        <div class="mb-4">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mahasiswa.logbooks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="tanggal" class="block">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" class="border rounded p-2" required />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="jam_mulai" class="block">Jam Mulai</label>
                <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" class="border rounded p-2" required />
            </div>
            <div>
                <label for="jam_selesai" class="block">Jam Selesai</label>
                <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" class="border rounded p-2" required />
            </div>
        </div>

        <div>
            <label for="aktivitas" class="block">Aktivitas</label>
            <textarea id="aktivitas" name="aktivitas" class="border rounded p-2 w-full" rows="6" required>{{ old('aktivitas') }}</textarea>
        </div>

        <div>
            <label for="foto" class="block">Foto Kegiatan (opsional)</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="border rounded p-2" />
        </div>

        <div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('mahasiswa.logbooks.index') }}" class="ml-2 text-gray-700">Batal</a>
        </div>
    </form>
</div>
@endsection
