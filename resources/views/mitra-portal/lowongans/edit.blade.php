<x-app-layout>
<div class="container mx-auto py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Lowongan</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mitra.lowongans.update', $lowongan) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Judul Lowongan</label>
            <input type="text" id="title" name="title" value="{{ old('title', $lowongan->title) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   required>
            @error('title')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="position" class="block text-gray-700 font-bold mb-2">Posisi</label>
            <input type="text" id="position" name="position" value="{{ old('position', $lowongan->position) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   placeholder="cth: Programmer, Designer">
            @error('position')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="location" class="block text-gray-700 font-bold mb-2">Lokasi</label>
            <input type="text" id="location" name="location" value="{{ old('location', $lowongan->location) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   placeholder="cth: Jakarta, Remote">
            @error('location')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="salary" class="block text-gray-700 font-bold mb-2">Gaji</label>
            <input type="text" id="salary" name="salary" value="{{ old('salary', $lowongan->salary) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   placeholder="cth: 5-8 juta/bulan">
            @error('salary')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea id="description" name="description" rows="6" 
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $lowongan->description) }}</textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Perbarui
            </button>
            <a href="{{ route('mitra.lowongans.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
                Batal
            </a>
        </div>
    </form>
</div>
</x-app-layout>
