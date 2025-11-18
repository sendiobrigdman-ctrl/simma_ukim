@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Penilaian Kinerja Mahasiswa</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($aplikasis->isEmpty())
        <p>Tidak ada mahasiswa yang sedang magang di perusahaan Anda.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Lowongan</th>
                    <th>Nilai Kinerja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($aplikasis as $aplikasi)
                <tr>
                    <td>{{ $aplikasi->user->name ?? '—' }}</td>
                    <td>{{ $aplikasi->lowongan->title ?? '—' }}</td>
                    <td>{{ $aplikasi->nilai?->nilai_mitra ?? '—' }}</td>
                    <td>
                        <a href="{{ route('mitra.penilaian.edit', $aplikasi) }}" class="btn btn-primary btn-sm">Input Nilai</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
