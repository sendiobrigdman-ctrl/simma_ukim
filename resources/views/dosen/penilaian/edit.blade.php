@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Input Nilai — {{ $aplikasi->user->name ?? '—' }}</h1>

    <form action="{{ route('dosen.penilaian.update', $aplikasi) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nilai_bimbingan" class="form-label">Nilai Bimbingan (0-100)</label>
            <input type="number" name="nilai_bimbingan" id="nilai_bimbingan" class="form-control" min="0" max="100" value="{{ old('nilai_bimbingan', $aplikasi->nilai->nilai_bimbingan ?? '') }}">
            @error('nilai_bimbingan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nilai_laporan_akhir" class="form-label">Nilai Laporan Akhir (0-100)</label>
            <input type="number" name="nilai_laporan_akhir" id="nilai_laporan_akhir" class="form-control" min="0" max="100" value="{{ old('nilai_laporan_akhir', $aplikasi->nilai->nilai_laporan_akhir ?? '') }}">
            @error('nilai_laporan_akhir')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
