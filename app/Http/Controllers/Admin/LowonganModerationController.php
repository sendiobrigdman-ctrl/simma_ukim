<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganModerationController extends Controller
{
    public function index(Request $request)
    {
        $lowongans = Lowongan::where('status', Lowongan::STATUS_PENDING)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.lowongans.moderation.index', compact('lowongans'));
    }

    public function show(Lowongan $lowongan)
    {
        return view('admin.lowongans.moderation.show', compact('lowongan'));
    }

    public function updateStatus(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', [Lowongan::STATUS_APPROVED, Lowongan::STATUS_REJECTED, Lowongan::STATUS_PENDING])],
        ]);

        $status = $request->input('status');
        $lowongan->status = $status;
        $lowongan->save();

        return redirect()->route('admin.lowongans.moderation.index')->with('status', 'lowongan-updated');
    }
}
