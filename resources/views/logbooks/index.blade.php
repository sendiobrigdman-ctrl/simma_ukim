@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Buku Harian Kegiatan</h1>
        <a href="{{ route('mahasiswa.logbooks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Entri</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if($logbooks->count())
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Jam</th>
                    <th class="border px-4 py-2">Aktivitas</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logbooks as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $log->tanggal->format('Y-m-d') }}</td>
                        <td class="border px-4 py-2">{{ $log->jam_mulai }} - {{ $log->jam_selesai }}</td>
                        <td class="border px-4 py-2">{{ Str::limit($log->aktivitas, 120) }}</td>
                        <td class="border px-4 py-2">
                            @if($log->status === \App\Models\Logbook::STATUS_PENDING)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($log->status === \App\Models\Logbook::STATUS_APPROVED)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            @elseif($log->status === \App\Models\Logbook::STATUS_REJECTED)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if($log->isPending())
                                <form action="{{ route('mahasiswa.logbooks.destroy', $log) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $logbooks->links() }}</div>
    @else
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">Belum ada entri logbook.</div>
    @endif
</div>
@endsection
