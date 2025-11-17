<?php

namespace App\Policies;

use App\Models\Aplikasi;
use App\Models\User;

class AplikasiPolicy
{
    /**
     * Check if user can view this application
     * (only mitra whose lowongan this aplikasi belongs to can view)
     */
    public function view(User $user, Aplikasi $aplikasi): bool
    {
        return $aplikasi->lowongan?->mitra_id === $user->id;
    }

    /**
     * Check if user can update application status
     * (only mitra whose lowongan this aplikasi belongs to can update)
     */
    public function update(User $user, Aplikasi $aplikasi): bool
    {
        return $aplikasi->lowongan?->mitra_id === $user->id;
    }
}
