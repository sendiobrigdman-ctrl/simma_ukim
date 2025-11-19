@component('mail::message')

# Status Lowongan Anda Telah Diperbarui

Hai {{ optional($lowongan->mitra)->name ?? 'Mitra' }},

Lowongan berjudul **{{ $lowongan->title }}** saat ini memiliki status **{{ ucfirst($status) }}**.

@if($status === 'approved')
Lowongan Anda sekarang Live dan dapat dilihat oleh mahasiswa.
@elseif($status === 'rejected')
Lowongan Anda ditolak. Mohon periksa kembali dan lakukan perbaikan jika diperlukan.
@else
Status lowongan: {{ ucfirst($status) }}.
@endif

Terima kasih,
Tim SIMMA

@endcomponent
