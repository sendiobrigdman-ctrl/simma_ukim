<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LamaranStatusUpdated;

class MitraPelamarController extends Controller
{
    public function index(Lowongan $lowongan)
    {
        $user = request()->user();
        if (! $user || ($user->role ?? null) !== 'mitra' || $lowongan->mitra_id !== $user->id) {
            abort(403);
        }

        $aplikasis = $lowongan->aplikasis()->with('user')->orderBy('created_at', 'desc')->get();

        return view('mitra-portal.pelamar.index', compact('lowongan', 'aplikasis'));
    }

    public function updateStatus(Request $request, Aplikasi $aplikasi)
    {
        $user = $request->user();
        $lowongan = $aplikasi->lowongan;

        if (! $user || ($user->role ?? null) !== 'mitra' || $lowongan->mitra_id !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'status_aplikasi' => 'required|string',
        ]);

        $aplikasi->update(['status_aplikasi' => $data['status_aplikasi']]);

        // Send notification to the applicant
        try {
            Mail::to($aplikasi->user->email)->send(new LamaranStatusUpdated($aplikasi));
        } catch (\Exception $e) {
            // If sending fails, we'll still continue — make it non-blocking for the UI
            // Consider logging in production.
        }

        return redirect()->back()->with('success', 'Status pelamar berhasil diupdate.');
    }
}
