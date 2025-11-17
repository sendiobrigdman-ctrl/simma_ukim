<?php

namespace App\Exports;

use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class NilaiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    public function collection(): Collection
    {
        return Nilai::all();
    }

    public function headings(): array
    {
        return ['Nilai'];
    }

    public function map($nilai): array
    {
        return [$nilai->value];
    }

    public function columnFormats(): array
    {
        // Column A (Nilai) as integer/number format
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
