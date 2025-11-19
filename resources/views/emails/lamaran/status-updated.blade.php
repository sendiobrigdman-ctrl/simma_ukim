<div style="font-family: sans-serif; line-height: 1.5;">
    <h2>Status Lamaran Diperbarui</h2>

    <p>Halo {{ $aplikasi->user->name }},</p>

    <p>Status lamaran Anda untuk lowongan <strong>{{ $aplikasi->lowongan->title ?? 'Lowongan' }}</strong> telah diperbarui menjadi:</p>

    <p style="font-weight: 700">{{ $aplikasi->status_label }}</p>

    @if($aplikasi->lowongan)
        <p>Perusahaan: {{ $aplikasi->lowongan->company_name ?? ($aplikasi->lowongan->mitra->name ?? '') }}</p>
    @endif

    <p>Silakan login untuk melihat detail lebih lanjut.</p>

    <p>Terima kasih,<br>Tim SIMMA</p>
</div>
