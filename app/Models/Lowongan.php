<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'mitra_id', 'position', 'location', 'salary'];

    // Status constants for moderation
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    /**
     * Check if lowongan is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Approve this lowongan.
     */
    public function approve(): void
    {
        $this->status = self::STATUS_APPROVED;
        $this->save();
    }

    /**
     * Reject this lowongan.
     */
    public function reject(): void
    {
        $this->status = self::STATUS_REJECTED;
        $this->save();
    }

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function aplikasis()
    {
        return $this->hasMany(Aplikasi::class);
    }
}
