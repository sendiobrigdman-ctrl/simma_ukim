<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = ['aplikasi_id', 'nilai_disiplin', 'nilai_kerja', 'catatan'];

    public function aplikasi()
    {
        return $this->belongsTo(Aplikasi::class);
    }

    public function getRataRataAttribute(): float
    {
        $d = $this->nilai_disiplin ?? 0;
        $k = $this->nilai_kerja ?? 0;
        return round((($d + $k) / 2), 2);
    }
}
