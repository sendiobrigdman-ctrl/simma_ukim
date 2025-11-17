<?php

namespace App\Exports;

use App\Models\Logbook;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LogbooksIndexExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
}
