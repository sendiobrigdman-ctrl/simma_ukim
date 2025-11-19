<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AplikasiController extends Controller
{
    /**
     * Download CV for an application. Only admin or the mitra owner of the lowongan may download.
     */
    public function downloadCv(Aplikasi $aplikasi)
    {
        $user = request()->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        // Ensure CV exists
        if (! $aplikasi->cv_path) {
            abort(404);
        }

        $isAdmin = ($user->role ?? null) === 'admin';
        $isMitraOwner = ($user->role ?? null) === 'mitra' && optional($aplikasi->lowongan)->mitra_id === $user->id;

        if (! ($isAdmin || $isMitraOwner)) {
            abort(403);
        }

        return Storage::download($aplikasi->cv_path);
    }
}
