<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraPenilaianController extends Controller
{
    /**
     * Display list of applications where mitra can input nilai_mitra.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all applications linked to lowongans owned by this mitra
        $aplikasis = Aplikasi::with(['user', 'lowongan', 'nilai'])
            ->whereHas('lowongan', function ($query) use ($user) {
                $query->where('mitra_id', $user->id);
            })
            ->get();

        return view('mitra.penilaian.index', compact('aplikasis'));
    }

    /**
     * Show edit form for inputting nilai_mitra.
     */
    public function edit(Aplikasi $aplikasi)
    {
        $this->authorize('manageNilaiMitra', $aplikasi);

        return view('mitra.penilaian.edit', compact('aplikasi'));
    }

    /**
     * Update nilai_mitra for an application.
     */
    public function update(Request $request, Aplikasi $aplikasi)
    {
        $this->authorize('manageNilaiMitra', $aplikasi);

        $data = $request->validate([
            'nilai_mitra' => ['nullable', 'integer', 'between:0,100'],
        ]);

        $nilai = $aplikasi->nilai;
        if (! $nilai) {
            $nilai = new Nilai();
            $nilai->aplikasi_id = $aplikasi->id;
        }

        $nilai->nilai_mitra = $data['nilai_mitra'] ?? null;
        $nilai->save();

        return redirect()->route('mitra.penilaian.index')->with('status', 'Nilai kinerja berhasil disimpan.');
    }

    /**
     * Show final grading form for an application (penilaian).
     */
    public function create(Aplikasi $aplikasi)
    {
        $user = auth()->user();

        // Only mitra owner can grade
        if ($aplikasi->lowongan->mitra_id !== $user->id) {
            abort(403);
        }

        return view('mitra.penilaian.create', compact('aplikasi'));
    }

    /**
     * Store final penilaian for an application.
     */
    public function store(Request $request, Aplikasi $aplikasi)
    {
        $user = auth()->user();

        if ($aplikasi->lowongan->mitra_id !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'nilai_disiplin' => ['required', 'integer', 'between:0,100'],
            'nilai_kerja' => ['required', 'integer', 'between:0,100'],
            'catatan' => ['nullable', 'string'],
        ]);

        // create or update penilaian
        $penilaian = \App\Models\Penilaian::updateOrCreate(
            ['aplikasi_id' => $aplikasi->id],
            [
                'nilai_disiplin' => $data['nilai_disiplin'],
                'nilai_kerja' => $data['nilai_kerja'],
                'catatan' => $data['catatan'] ?? null,
            ]
        );

        return redirect()->route('mitra.penilaian.index')->with('status', 'Penilaian berhasil disimpan.');
    }
}
