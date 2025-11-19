<x-app-layout>
<div class="container mx-auto py-8 max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $lowongan->title }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('mitra.lowongans.edit', $lowongan) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                Edit
            </a>
            <form method="POST" action="{{ route('mitra.lowongans.destroy', $lowongan) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Detail Lowongan</h2>
        
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-700">Posisi</h3>
            <p class="text-gray-600">{{ $lowongan->position ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-700">Lokasi</h3>
            <p class="text-gray-600">{{ $lowongan->location ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-700">Gaji</h3>
            <p class="text-gray-600">{{ $lowongan->salary ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-700">Deskripsi</h3>
            <p class="text-gray-600 whitespace-pre-wrap">{{ $lowongan->description ?? '-' }}</p>
        </div>
    </div>

    <!-- Applicants Section -->
    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            Daftar Pelamar ({{ $lowongan->aplikasis->count() }})
        </h2>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ $message }}
            </div>
        @endif

        @if ($lowongan->aplikasis->count())
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama Pelamar</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowongan->aplikasis as $aplikasi)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">{{ $aplikasi->user->name ?? '-' }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $aplikasi->user->email ?? '-' }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <span class="px-3 py-1 rounded text-sm font-semibold
                                        @if ($aplikasi->status_aplikasi === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif ($aplikasi->status_aplikasi === 'diterima_mitra') bg-green-100 text-green-700
                                        @else bg-red-100 text-red-700
                                        @endif
                                    ">
                                        {{ $aplikasi->status_label }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($aplikasi->status_aplikasi !== 'diterima_mitra')
                                        <form method="POST" action="{{ route('mitra.aplikasi.updateStatus', $aplikasi) }}" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_aplikasi" value="diterima_mitra">
                                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                                                Terima
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if ($aplikasi->status_aplikasi !== 'ditolak_mitra')
                                        <form method="POST" action="{{ route('mitra.aplikasi.updateStatus', $aplikasi) }}" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_aplikasi" value="ditolak_mitra">
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm ml-2">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                        @if ($aplikasi->cv_path && (auth()->user()->role === 'admin' || (auth()->user()->role === 'mitra' && auth()->id() === $lowongan->mitra_id)))
                                            <a href="{{ route('aplikasi.downloadCv', $aplikasi) }}" class="inline-flex items-center bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm ml-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v12m0 0l-4-4m4 4l4-4M21 21H3"></path></svg>
                                                Download CV
                                            </a>
                                        @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-3 rounded">
                Belum ada pelamar untuk lowongan ini.
            </div>
        @endif
    </div>

    <a href="{{ route('mitra.lowongans.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Kembali
    </a>
</div>
</x-app-layout>
