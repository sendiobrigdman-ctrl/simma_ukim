<?php

namespace App\Exports;

use App\Models\Lowongan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LowonganExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Lowongan::all()->map(fn($l) => [$l->title]);
    }

    public function headings(): array
    {
        return ['Lowongan'];
    }
}
