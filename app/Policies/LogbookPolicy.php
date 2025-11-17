<?php

namespace App\Policies;

use App\Models\Logbook;
use App\Models\User;

class LogbookPolicy
{
    /**
     * Determine whether the user can view the logbook.
     */
    public function view(User $user, Logbook $logbook): bool
    {
        return ($logbook->aplikasi->dosen_id ?? null) === $user->id;
    }

    /**
     * Determine whether the user can update (validate/reject) the logbook.
     */
    public function update(User $user, Logbook $logbook): bool
    {
        return ($logbook->aplikasi->dosen_id ?? null) === $user->id;
    }
}
