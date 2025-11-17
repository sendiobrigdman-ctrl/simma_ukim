<?php

namespace App\Exports;

use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class NilaiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting, WithStyles, WithEvents
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

    public function styles($sheet)
    {
        // Make header row bold
        $sheet->getStyle('1')->getFont()->setBold(true);

        return $sheet;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Freeze the header row (row 1)
                $event->sheet->freezePane('A2');
            },
        ];
    }
}
