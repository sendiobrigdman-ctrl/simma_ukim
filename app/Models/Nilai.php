<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'nilai_bimbingan', 'nilai_laporan_akhir', 'nilai_mitra'];

    /**
     * Calculate average of available scores (bimbingan, laporan, mitra).
     * Returns null if no scores present.
     */
    public function getNilaiRataRataAttribute()
    {
        $values = array_filter([
            $this->nilai_bimbingan,
            $this->nilai_laporan_akhir,
            $this->nilai_mitra,
        ], function ($v) {
            return $v !== null;
        });

        if (empty($values)) {
            return null;
        }

        return (int) round(array_sum($values) / count($values));
    }

    public function aplikasi()
    {
        return $this->belongsTo(\App\Models\Aplikasi::class, 'aplikasi_id');
    }
}
