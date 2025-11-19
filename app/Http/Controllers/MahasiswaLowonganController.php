<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class MahasiswaLowonganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua lowongan yang tersedia (kolom status tidak ada di skema saat ini)
        $lowongans = Lowongan::orderBy('created_at', 'desc')->paginate(10);
        return view('mahasiswa.lowongan.index', compact('lowongans'));
    }

    public function show(Lowongan $lowongan)
    {
        // Tampilkan detail lowongan
        return view('mahasiswa.lowongan.show', compact('lowongan'));
    }
}