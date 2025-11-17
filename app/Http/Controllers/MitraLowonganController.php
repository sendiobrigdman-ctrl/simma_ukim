<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Http\Requests\StoreLowonganRequest;
use App\Http\Requests\UpdateLowonganRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MitraLowonganController extends Controller
{
    /**
     * Display a listing of lowongans for the authenticated mitra.
     */
    public function index(Request $request)
    {
        $lowongans = $request->user()->lowongans()->paginate(10);

        return view('mitra-portal.lowongans.index', compact('lowongans'));
    }

    /**
     * Show the form for creating a new lowongan.
     */
    public function create()
    {
        return view('mitra-portal.lowongans.create');
    }

    /**
     * Store a newly created lowongan.
     */
    public function store(StoreLowonganRequest $request)
    {
        $request->user()->lowongans()->create($request->validated());

        return redirect()->route('mitra.lowongans.index')
            ->with('success', 'Lowongan berhasil dibuat.');
    }

    /**
     * Display the specified lowongan.
     */
    public function show(Lowongan $lowongan)
    {
        Gate::authorize('view', $lowongan);

        return view('mitra-portal.lowongans.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified lowongan.
     */
    public function edit(Lowongan $lowongan)
    {
        Gate::authorize('update', $lowongan);

        return view('mitra-portal.lowongans.edit', compact('lowongan'));
    }

    /**
     * Update the specified lowongan.
     */
    public function update(UpdateLowonganRequest $request, Lowongan $lowongan)
    {
        Gate::authorize('update', $lowongan);

        $lowongan->update($request->validated());

        return redirect()->route('mitra.lowongans.show', $lowongan)
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Delete the specified lowongan.
     */
    public function destroy(Lowongan $lowongan)
    {
        Gate::authorize('delete', $lowongan);

        $lowongan->delete();

        return redirect()->route('mitra.lowongans.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }
}
