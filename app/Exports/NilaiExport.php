<?php

namespace App\Exports;

use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Nilai::all()->map(fn($n) => [$n->value]);
    }

    public function headings(): array
    {
        return ['Nilai'];
    }
}
