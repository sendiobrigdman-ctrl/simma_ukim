@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Penilaian Mahasiswa Bimbingan</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($aplikasis->isEmpty())
        <p>Tidak ada mahasiswa bimbingan.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Lowongan</th>
                    <th>Nilai Rata-rata</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($aplikasis as $aplikasi)
                <tr>
                    <td>{{ $aplikasi->user->name ?? '—' }}</td>
                    <td>{{ $aplikasi->lowongan->title ?? '—' }}</td>
                    <td>{{ $aplikasi->nilai?->nilai_rata_rata ?? '—' }}</td>
                    <td>
                        @can('manageNilai', $aplikasi)
                            <a href="{{ route('dosen.penilaian.edit', $aplikasi) }}" class="btn btn-primary btn-sm">Input Nilai</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
