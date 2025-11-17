<?php

namespace App\Exports;

use App\Models\Lowongan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LowonganExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    public function collection(): Collection
    {
        return Lowongan::all();
    }

    public function headings(): array
    {
        return ['Lowongan'];
    }

    public function map($lowongan): array
    {
        return [$lowongan->title];
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
