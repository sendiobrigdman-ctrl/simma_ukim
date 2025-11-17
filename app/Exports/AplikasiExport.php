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
        // Use model accessor for readable status
        return [$aplikasi->name, $aplikasi->status_label];
    }
}
