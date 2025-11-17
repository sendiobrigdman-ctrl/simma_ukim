<?php

namespace App\Exports;

use App\Models\Lowongan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LowonganExport implements FromCollection, WithHeadings, WithMapping
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
}
