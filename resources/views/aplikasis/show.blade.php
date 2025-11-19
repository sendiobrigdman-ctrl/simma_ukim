@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Detail Lamaran</h1>

    @if(!isset($aplikasi))
        <div class="p-4 bg-yellow-50 rounded">Data lamaran tidak ditemukan.</div>
    @else
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4">
                <div class="text-lg font-medium">{{ $aplikasi->lowongan->title ?? 'Lowongan' }}</div>
                <div class="text-sm text-gray-600">Diajukan: {{ $aplikasi->created_at->format('d M Y') }}</div>
            </div>

            <div class="mb-4">
                <strong>Status:</strong>
                @php $status = $aplikasi->status_aplikasi ?? 'pending'; @endphp
                <span class="ml-2 px-2 py-1 rounded text-sm {{ $status === 'diterima_mitra' ? 'bg-green-100 text-green-800' : ($status === 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ $aplikasi->status_label ?? ucfirst($status) }}
                </span>
            </div>

            <div class="mb-4">
                <strong>CV:</strong>
                @if($aplikasi->cv_path)
                    <a href="{{ route('aplikasi.downloadCv', $aplikasi->id) }}" class="text-blue-600 ml-2">Download CV</a>
                @else
                    <span class="ml-2 text-gray-600">Tidak ada CV terunggah.</span>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 bg-gray-100 rounded">Kembali</a>
            </div>
        </div>
    @endif
</div>
@endsection
