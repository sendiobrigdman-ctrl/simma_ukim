<?php

namespace App\Policies;

use App\Models\Lowongan;
use App\Models\User;

class LowonganPolicy
{
    public function view(User $user, Lowongan $lowongan): bool
    {
        return $lowongan->mitra_id === $user->id;
    }

    public function update(User $user, Lowongan $lowongan): bool
    {
        return $lowongan->mitra_id === $user->id;
    }

    public function delete(User $user, Lowongan $lowongan): bool
    {
        return $lowongan->mitra_id === $user->id;
    }
}
