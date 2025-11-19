@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-6">Logbook Mahasiswa (Verifikasi Mitra)</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Mahasiswa</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Aktivitas</th>
                        <th class="px-4 py-2 text-left">Foto</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logbooks as $logbook)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $logbook->user->name ?? '—' }}</td>
                            <td class="px-4 py-2">{{ optional($logbook->tanggal)->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">{{ $logbook->aktivitas ?? ($logbook->content ?? '') }}</td>
                            <td class="px-4 py-2">
                                @if($logbook->foto_kegiatan_path)
                                    <a class="text-indigo-600 hover:underline" href="{{ Storage::url($logbook->foto_kegiatan_path) }}" target="_blank">Lihat</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ ucfirst($logbook->status) }}</td>
                            <td class="px-4 py-2">
                                @if($logbook->status === \App\Models\Logbook::STATUS_PENDING)
                                    <form method="POST" action="{{ route('mitra.logbooks.updateStatus', $logbook) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ \App\Models\Logbook::STATUS_APPROVED }}">
                                        <button class="bg-green-600 text-white px-3 py-1 rounded">Setujui</button>
                                    </form>
                                    <form method="POST" action="{{ route('mitra.logbooks.updateStatus', $logbook) }}" class="inline-block ms-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ \App\Models\Logbook::STATUS_REJECTED }}">
                                        <button class="bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada logbook untuk diverifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $logbooks->links() }}
    </div>
</div>
@endsection
