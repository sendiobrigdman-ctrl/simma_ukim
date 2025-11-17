<?php

namespace App\Exports;

use App\Models\Logbook;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogbooksIndexExport implements FromCollection, WithHeadings
{
    protected $aplikasiId;

    public function __construct($aplikasiId)
    {
        $this->aplikasiId = $aplikasiId;
    }

    public function collection(): Collection
    {
        // In production this might return an index summary; for tests we'll return content
        return Logbook::where('aplikasi_id', $this->aplikasiId)->get()->map(fn($l) => [$l->content]);
    }

    public function headings(): array
    {
        return ['Logbooks Index'];
    }
}
