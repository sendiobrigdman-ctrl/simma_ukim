<x-app-layout>
<div class="container mx-auto py-8 max-w-2xl">
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

    <div class="bg-white rounded shadow p-6">
        <div class="mb-4">
            <h2 class="text-lg font-bold text-gray-700">Posisi</h2>
            <p class="text-gray-600">{{ $lowongan->position ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-bold text-gray-700">Lokasi</h2>
            <p class="text-gray-600">{{ $lowongan->location ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-bold text-gray-700">Gaji</h2>
            <p class="text-gray-600">{{ $lowongan->salary ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-bold text-gray-700">Deskripsi</h2>
            <p class="text-gray-600 whitespace-pre-wrap">{{ $lowongan->description ?? '-' }}</p>
        </div>

        <a href="{{ route('mitra.lowongans.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kembali
        </a>
    </div>
</div>
</x-app-layout>
