@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Input Nilai Kinerja — {{ $aplikasi->user->name ?? '—' }}</h1>

    <form action="{{ route('mitra.penilaian.update', $aplikasi) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nilai_mitra" class="form-label">Nilai Kinerja (0-100)</label>
            <input type="number" name="nilai_mitra" id="nilai_mitra" class="form-control" min="0" max="100" value="{{ old('nilai_mitra', $aplikasi->nilai->nilai_mitra ?? '') }}">
            @error('nilai_mitra')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('mitra.penilaian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
