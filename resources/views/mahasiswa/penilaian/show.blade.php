@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-6">Hasil Penilaian</h1>

    @if(! $penilaian)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded">Penilaian belum tersedia.</div>
    @else
        <div class="bg-white shadow rounded p-4">
            <p><strong>Nilai Disiplin:</strong> {{ $penilaian->nilai_disiplin }}</p>
            <p><strong>Nilai Kerja:</strong> {{ $penilaian->nilai_kerja }}</p>
            <p><strong>Rata-rata:</strong> {{ $penilaian->rata_rata }}</p>
            @if($penilaian->catatan)
                <div class="mt-4">
                    <h4 class="font-semibold">Catatan</h4>
                    <p class="text-sm text-gray-700">{{ $penilaian->catatan }}</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
