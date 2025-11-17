<?php

namespace App\Exports;

use App\Models\Aplikasi;
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
use PhpOffice\PhpSpreadsheet\Style\Font;

class AplikasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting, WithStyles, WithEvents
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
