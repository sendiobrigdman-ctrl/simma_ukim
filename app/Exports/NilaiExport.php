<?php

namespace App\Exports;

use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings, WithMapping
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
}
