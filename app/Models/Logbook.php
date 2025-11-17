<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = ['aplikasi_id', 'content'];

    public function aplikasi()
    {
        return $this->belongsTo(Aplikasi::class);
    }

    /**
     * Human readable validation status label.
     * Usage: $logbook->status_label
     */
    public function getStatusLabelAttribute(): string
    {
        $status = $this->status_validasi ?? null;

        $map = [
            'menunggu' => 'Menunggu Validasi',
            'divalidasi' => 'Divalidasi',
            'ditolak' => 'Ditolak',
        ];

        if ($status === null) {
            return '';
        }

        return $map[$status] ?? $status;
    }
}
