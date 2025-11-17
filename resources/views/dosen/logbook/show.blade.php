@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Logbook</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Mahasiswa:</strong> {{ $logbook->aplikasi->user->name ?? '—' }}</p>
            <p><strong>Konten:</strong></p>
            <p>{{ $logbook->content }}</p>
            <p><strong>Status:</strong> {{ $logbook->status_label }}</p>
        </div>
    </div>
</div>
@endsection
