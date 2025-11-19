@extends('layouts.app')

@section('content')
<div class="container mx-auto">
	<h1 class="text-2xl font-semibold mb-4">Daftar Lamaran Saya</h1>

	@if(isset($aplikasis) && $aplikasis->isEmpty())
		<p>Tidak ada lamaran.</p>
	@else
		<div class="space-y-4">
			@foreach($aplikasis as $aplikasi)
				<div class="p-4 bg-white shadow rounded flex items-center justify-between">
					<div>
						<div class="text-lg font-medium">{{ $aplikasi->lowongan->title ?? 'Lowongan' }}</div>
						<div class="text-sm text-gray-600">{{ $aplikasi->created_at->format('d M Y') }}</div>
					</div>
					<div class="flex items-center space-x-4">
						@php
							$status = $aplikasi->status_aplikasi ?? 'pending';
							$label = $aplikasi->status_label;
							$color = match($status) {
								'diterima_mitra' => 'bg-green-100 text-green-800',
								'ditolak' => 'bg-red-100 text-red-800',
								default => 'bg-yellow-100 text-yellow-800',
							};
						@endphp

						<span class="px-3 py-1 rounded-full text-sm {{ $color }}">{{ $label }}</span>

						<a href="{{ route('aplikasis.show', $aplikasi->id) }}" class="text-sm text-blue-600">Lihat</a>
					</div>
				</div>
			@endforeach
		</div>
	@endif
</div>
@endsection

