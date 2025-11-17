<?php

namespace App\Exports;

use App\Models\Aplikasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AplikasiExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Aplikasi::all()->map(fn($a) => [$a->name]);
    }

    public function headings(): array
    {
        return ['Aplikasi'];
    }
}
