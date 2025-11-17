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
}
