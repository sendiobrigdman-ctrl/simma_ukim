<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaAplikasiController extends Controller
{
    // Form create lamaran (opsional, biasanya di halaman show lowongan)
    public function create(Lowongan $lowongan)
    {
        // Bisa redirect ke show lowongan atau tampilkan form khusus
        return view('mahasiswa.lowongan.apply', compact('lowongan'));
    }

    public function store(Request $request, Lowongan $lowongan)
    {
        $user = Auth::user();
        // Validasi sederhana, misal hanya satu lamaran per user per lowongan
        $exists = Aplikasi::where('user_id', $user->id)->where('lowongan_id', $lowongan->id)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah melamar lowongan ini.');
        }

        $data = $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs');

        Aplikasi::create([
            'user_id' => $user->id,
            'lowongan_id' => $lowongan->id,
            'cv_path' => $cvPath,
        ]);
        return redirect()->route('mahasiswa.lowongan.index')->with('success', 'Lamaran berhasil diajukan.');
    }
}