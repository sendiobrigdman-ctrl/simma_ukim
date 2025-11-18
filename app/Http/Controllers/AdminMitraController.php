<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class AdminMitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::orderBy('id', 'desc')->paginate(20);
        return view('admin.mitra.index', compact('mitras'));
    }

    public function create()
    {
        return view('admin.mitra.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email_kontak' => 'required|email|max:255',
            'telepon_kontak' => 'required|string|max:50',
            'status' => 'required|in:aktif,non-aktif',
        ]);
        Mitra::create($data);
        return redirect()->route('admin.mitra.index')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function edit(Mitra $mitra)
    {
        return view('admin.mitra.edit', compact('mitra'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $data = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email_kontak' => 'required|email|max:255',
            'telepon_kontak' => 'required|string|max:50',
            'status' => 'required|in:aktif,non-aktif',
        ]);
        $mitra->update($data);
        return redirect()->route('admin.mitra.index')->with('success', 'Data mitra berhasil diupdate.');
    }

    public function destroy(Mitra $mitra)
    {
        $mitra->delete();
        return redirect()->route('admin.mitra.index')->with('success', 'Data mitra berhasil dihapus.');
    }
}