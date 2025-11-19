@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Moderasi Lowongan</h1>

        @if(session('status') === 'lowongan-updated')
            <div class="alert alert-success">Perubahan status lowongan berhasil.</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Mitra</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowongans as $lowongan)
                    <tr>
                        <td>{{ $lowongan->title }}</td>
                        <td>{{ optional($lowongan->mitra)->name }}</td>
                        <td>{{ $lowongan->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.lowongans.moderation.show', $lowongan) }}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $lowongans->links() }}
    </div>
@endsection
