<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sertifikat Magang</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; }
        .page { width: 297mm; height: 210mm; padding: 30mm; box-sizing: border-box; }
        .card { border: 6px solid #2b6cb0; height: 100%; padding: 20px; display:flex; flex-direction:column; justify-content:center; align-items:center; }
        .title { font-size: 28px; font-weight:700; margin-bottom: 8px; }
        .subtitle { font-size: 18px; margin-bottom: 18px; }
        .content { font-size: 16px; max-width: 800px; text-align:center; }
        .no-print { margin-top: 20px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="title">Sertifikat Magang</div>
            <div class="subtitle">Diberikan kepada</div>
            <div style="font-size:22px;font-weight:600;margin-bottom:8px">{{ $aplikasi->user->name ?? '-' }}</div>
            <div class="content">
                <p>Telah menyelesaikan program magang di <strong>{{ $aplikasi->lowongan->mitra->name ?? ($aplikasi->lowongan->mitra->company_name ?? 'Perusahaan') }}</strong>.</p>
                <p>Tanggal: {{ now()->format('d F Y') }}</p>
                <p style="margin-top:16px;font-weight:600">Telah menyelesaikan magang dengan nilai: {{ $penilaian->rata_rata }}</p>
            </div>

            <div class="no-print">
                <button onclick="window.print()" style="margin-top:20px;padding:10px 18px;background:#2563eb;color:#fff;border:none;border-radius:4px;">Print This Certificate</button>
            </div>
        </div>
    </div>
</body>
</html>
