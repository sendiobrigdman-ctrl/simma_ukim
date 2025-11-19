<x-app-layout>
<div class="container mx-auto py-8 max-w-5xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Pelamar untuk: {{ $lowongan->title }}</h1>
        <a href="{{ route('mitra.lowongans.show', $lowongan) }}" class="bg-gray-600 text-white px-3 py-1 rounded">Kembali</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded shadow p-4">
        @if($aplikasis->isEmpty())
            <div class="text-gray-500">Belum ada pelamar.</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2">Nama Mahasiswa</th>
                            <th class="px-4 py-2">Tanggal Melamar</th>
                            <th class="px-4 py-2">CV</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aplikasis as $aplikasi)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $aplikasi->user->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $aplikasi->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2">
                                    @if($aplikasi->cv_path)
                                        <a href="{{ route('aplikasi.downloadCv', $aplikasi) }}" class="text-indigo-600 hover:underline">Download CV</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $aplikasi->status_label }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('mitra.lamaran.updateStatus', $aplikasi) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_aplikasi" value="diterima_mitra">
                                        <button class="bg-green-600 text-white px-3 py-1 rounded text-sm">Terima</button>
                                    </form>

                                    <form method="POST" action="{{ route('mitra.lamaran.updateStatus', $aplikasi) }}" class="inline-block ml-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status_aplikasi" value="ditolak_mitra">
                                        <button class="bg-red-600 text-white px-3 py-1 rounded text-sm">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
</x-app-layout>
