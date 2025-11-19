<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class MahasiswaLowonganController extends Controller
{
    public function index(Request $request)
    {
        // Only show approved lowongans to mahasiswa
        $lowongans = Lowongan::where('status', Lowongan::STATUS_APPROVED)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('mahasiswa.lowongan.index', compact('lowongans'));
    }

    public function show(Lowongan $lowongan)
    {
        // Tampilkan detail lowongan
        return view('mahasiswa.lowongan.show', compact('lowongan'));
    }
}