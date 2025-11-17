<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MitraAplikasiController extends Controller
{
    /**
     * Update the status of an application.
     */
    public function updateStatus(Request $request, Aplikasi $aplikasi)
    {
        Gate::authorize('update', $aplikasi);

        $validated = $request->validate([
            'status_aplikasi' => ['required', 'in:pending,diterima_mitra,ditolak_mitra'],
        ]);

        $aplikasi->update($validated);

        return redirect()->back()
            ->with('success', 'Status lamaran berhasil diperbarui.');
    }
}
