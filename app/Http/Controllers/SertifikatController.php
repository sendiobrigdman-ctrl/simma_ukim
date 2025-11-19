<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function show(Penilaian $penilaian)
    {
        $user = auth()->user();

        // Ensure penilaian is associated with an aplikasi and owned by the authenticated student
        if (! $penilaian->aplikasi || $penilaian->aplikasi->user_id !== $user->id) {
            abort(403);
        }

        return view('sertifikat.show', ['penilaian' => $penilaian, 'aplikasi' => $penilaian->aplikasi]);
    }
}
