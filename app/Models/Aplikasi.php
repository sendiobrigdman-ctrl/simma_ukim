<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aplikasi extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Human readable status label.
     * Usage: $aplikasi->status_label
     */
    public function getStatusLabelAttribute(): string
    {
        $status = $this->status_aplikasi ?? null;

        $map = [
            'pending' => 'Menunggu',
            'diterima_mitra' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];

        if ($status === null) {
            return '';
        }

        return $map[$status] ?? $status;
    }
}
