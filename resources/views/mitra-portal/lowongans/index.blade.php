<x-app-layout>
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Lowongan</h1>
        <a href="{{ route('mitra.lowongans.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Buat Lowongan
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    @if ($lowongans->count())
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Judul</th>
                        <th class="border border-gray-300 px-4 py-2">Posisi</th>
                        <th class="border border-gray-300 px-4 py-2">Lokasi</th>
                        <th class="border border-gray-300 px-4 py-2">Gaji</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lowongans as $lowongan)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $lowongan->title }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $lowongan->position ?? '-' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $lowongan->location ?? '-' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $lowongan->salary ?? '-' }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @php
                                    $status = $lowongan->status ?? 'pending';
                                @endphp
                                @if($status === \App\Models\Lowongan::STATUS_PENDING)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($status === \App\Models\Lowongan::STATUS_APPROVED)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                @elseif($status === \App\Models\Lowongan::STATUS_REJECTED)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($status) }}</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="{{ route('mitra.lowongans.show', $lowongan) }}" class="text-blue-600 hover:underline">Lihat</a>
                                <a href="{{ route('mitra.lowongans.edit', $lowongan) }}" class="text-yellow-600 hover:underline ml-2">Edit</a>
                                <form method="POST" action="{{ route('mitra.lowongans.destroy', $lowongan) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $lowongans->links() }}
        </div>
    @else
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            Anda belum membuat lowongan. <a href="{{ route('mitra.lowongans.create') }}" class="font-bold">Buat yang pertama sekarang</a>.
        </div>
    @endif
</div>
</x-app-layout>
