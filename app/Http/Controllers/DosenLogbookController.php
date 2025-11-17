<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenLogbookController extends Controller
{
    /**
     * Display a listing of the logbooks for the authenticated dosen.
     */
    public function index()
    {
        $user = Auth::user();

        // NOTE: This assumes there's a `dosen_id` column on `aplikasis`
        // that holds the assigned dosen's user id.
        $logbooks = Logbook::with(['aplikasi.user'])
            ->whereHas('aplikasi', function ($q) use ($user) {
                $q->where('dosen_id', $user->id);
            })
            ->get();

        return view('dosen.logbook.index', compact('logbooks'));
    }

    /**
     * Display a specific logbook entry (must belong to the dosen).
     */
    public function show(Logbook $logbook)
    {
        $this->authorize('view', $logbook);

        return view('dosen.logbook.show', compact('logbook'));
    }

    /**
     * Validate or reject a logbook entry.
     */
    public function update(Request $request, Logbook $logbook)
    {
        $user = Auth::user();

        $this->authorize('update', $logbook);

        $action = $request->input('action'); // expected: 'validate' or 'reject'

        if ($action === 'validate') {
            $logbook->status_validasi = 'divalidasi';
        } else {
            $logbook->status_validasi = 'ditolak';
        }

        $logbook->save();

        return redirect()->route('dosen.logbook.index')->with('status', 'Perubahan status logbook berhasil.');
    }
}
