<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenPenilaianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $aplikasis = Aplikasi::with(['user', 'nilai'])
            ->where('dosen_id', $user->id)
            ->get();

        return view('dosen.penilaian.index', compact('aplikasis'));
    }

    public function edit(Aplikasi $aplikasi)
    {
        $user = Auth::user();
        if (($aplikasi->dosen_id ?? null) !== $user->id) {
            abort(403);
        }

        return view('dosen.penilaian.edit', compact('aplikasi'));
    }

    public function update(Request $request, Aplikasi $aplikasi)
    {
        $user = Auth::user();
        if (($aplikasi->dosen_id ?? null) !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'nilai_bimbingan' => ['nullable', 'integer', 'between:0,100'],
            'nilai_laporan_akhir' => ['nullable', 'integer', 'between:0,100'],
        ]);

        $nilai = $aplikasi->nilai;
        if (! $nilai) {
            $nilai = new Nilai();
            $nilai->aplikasi_id = $aplikasi->id;
        }

        $nilai->nilai_bimbingan = $data['nilai_bimbingan'] ?? null;
        $nilai->nilai_laporan_akhir = $data['nilai_laporan_akhir'] ?? null;
        $nilai->save();

        return redirect()->route('dosen.penilaian.index')->with('status', 'Nilai berhasil disimpan.');
    }
}
