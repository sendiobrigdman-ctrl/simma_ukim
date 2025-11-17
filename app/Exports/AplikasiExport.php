<?php

namespace App\Exports;

use App\Models\Aplikasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AplikasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
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

    public function columnFormats(): array
    {
        // Column B (Status) as text
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
