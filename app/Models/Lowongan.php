<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'mitra_id', 'position', 'location', 'salary'];

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function aplikasis()
    {
        return $this->hasMany(Aplikasi::class);
    }
}
