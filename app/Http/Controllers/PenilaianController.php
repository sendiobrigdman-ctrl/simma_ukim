<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function show(Aplikasi $aplikasi)
    {
        $user = auth()->user();

        // Only the student who owns the aplikasi can view
        if ($aplikasi->user_id !== $user->id) {
            abort(403);
        }

        $penilaian = $aplikasi->penilaian ?? null;

        return view('mahasiswa.penilaian.show', compact('aplikasi', 'penilaian'));
    }
}
