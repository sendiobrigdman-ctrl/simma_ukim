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

    /**
     * Check if dosen can manage nilai bimbingan and laporan for this aplikasi
     */
    public function manageNilai(User $user, Aplikasi $aplikasi): bool
    {
        return ($aplikasi->dosen_id ?? null) === $user->id;
    }

    /**
     * Check if mitra can manage nilai_mitra for this aplikasi
     * (only mitra whose lowongan this aplikasi belongs to can update)
     */
    public function manageNilaiMitra(User $user, Aplikasi $aplikasi): bool
    {
        return $aplikasi->lowongan?->mitra_id === $user->id;
    }
}
