<?php

namespace App\Exports;

use App\Models\Logbook;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogbookExport implements FromCollection, WithHeadings
{
    protected $aplikasiId;

    public function __construct($aplikasiId)
    {
        $this->aplikasiId = $aplikasiId;
    }

    public function collection(): Collection
    {
        return Logbook::where('aplikasi_id', $this->aplikasiId)->get()->map(fn($l) => [$l->content]);
    }

    public function headings(): array
    {
        return ['Logbook'];
    }
}
