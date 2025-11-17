<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aplikasi extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'lowongan_id', 'status_aplikasi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function nilai()
    {
        return $this->hasOne(\App\Models\Nilai::class, 'aplikasi_id');
    }

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
