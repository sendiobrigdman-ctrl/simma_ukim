<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'email_kontak',
        'telepon_kontak',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
