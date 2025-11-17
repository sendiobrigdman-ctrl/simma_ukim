<?php

namespace App\Exports;

use App\Models\Logbook;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LogbooksIndexExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $aplikasiId;

    public function __construct($aplikasiId)
    {
        $this->aplikasiId = $aplikasiId;
    }

    public function collection(): Collection
    {
        return Logbook::where('aplikasi_id', $this->aplikasiId)->get();
    }

    public function headings(): array
    {
        return ['Logbooks Index'];
    }

    public function map($logbook): array
    {
        return [$logbook->content];
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
