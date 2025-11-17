@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Logbook Bimbingan</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($logbooks->isEmpty())
        <p>Tidak ada logbook untuk ditampilkan.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mahasiswa</th>
                    <th>Konten</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($logbooks as $logbook)
                <tr>
                    <td>{{ $logbook->aplikasi->user->name ?? '—' }}</td>
                    <td>{{ Str::limit($logbook->content, 100) }}</td>
                    <td>{{ $logbook->status_label ?? '' }}</td>
                    <td>
                        <form action="{{ route('dosen.logbook.update', $logbook) }}" method="POST" style="display:inline-block">
                            @csrf
                            <input type="hidden" name="action" value="validate">
                            <button class="btn btn-success btn-sm">Validasi</button>
                        </form>

                        <form action="{{ route('dosen.logbook.update', $logbook) }}" method="POST" style="display:inline-block">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
