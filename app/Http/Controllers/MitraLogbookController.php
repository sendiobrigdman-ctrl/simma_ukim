<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MitraLogbookController extends Controller
{
    public function index(Request $request)
    {
        $mitra = $request->user();

        // Find user IDs of students accepted by this mitra
        $acceptedStudentIds = Aplikasi::whereHas('lowongan', function ($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->where('status_aplikasi', 'diterima_mitra')->pluck('user_id')->toArray();

        $logbooks = Logbook::whereIn('user_id', $acceptedStudentIds)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('mitra.logbooks.index', compact('logbooks'));
    }

    public function updateStatus(Request $request, Logbook $logbook)
    {
        $mitra = $request->user();

        // Ensure this logbook belongs to a student accepted by this mitra
        $accepted = Aplikasi::where('user_id', $logbook->user_id)
            ->whereHas('lowongan', function ($q) use ($mitra) {
                $q->where('mitra_id', $mitra->id);
            })->where('status_aplikasi', 'diterima_mitra')->exists();

        if (! $accepted) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|string|in:'.Logbook::STATUS_APPROVED.','.Logbook::STATUS_REJECTED,
        ]);

        $logbook->status = $request->input('status');
        $logbook->save();

        return Redirect::back()->with('success', 'Status logbook diperbarui.');
    }
}
