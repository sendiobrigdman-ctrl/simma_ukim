<?php

namespace App\Exports;

use App\Models\Aplikasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AplikasiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Aplikasi::all();
    }

    public function headings(): array
    {
        return ['Aplikasi', 'Status'];
    }

    public function map($aplikasi): array
    {
        $status = $aplikasi->status_aplikasi ?? null;

        // map status codes to human-readable Indonesian labels
        $map = [
            'pending' => 'Menunggu',
            'diterima_mitra' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];

        $readable = $status !== null ? ($map[$status] ?? $status) : '';

        return [$aplikasi->name, $readable];
    }
}
