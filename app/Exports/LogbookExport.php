<?php

namespace App\Exports;

use App\Models\Logbook;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogbookExport implements FromCollection, WithHeadings, WithMapping
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
        return ['Logbook', 'Status Validasi'];
    }

    public function map($logbook): array
    {
        // Use model accessor for readable validation status
        return [$logbook->content, $logbook->status_label];
    }
}
