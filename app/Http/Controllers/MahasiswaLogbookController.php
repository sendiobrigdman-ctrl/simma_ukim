<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogbookRequest;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class MahasiswaLogbookController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $logbooks = Logbook::where('user_id', $user->id)->orderBy('tanggal', 'desc')->paginate(10);

        return view('logbooks.index', compact('logbooks'));
    }

    public function create()
    {
        return view('logbooks.create');
    }

    public function store(StoreLogbookRequest $request)
    {
        $user = $request->user();

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $disk = config('filesystems.default');
            $data['foto_kegiatan_path'] = $request->file('foto')->store('logbooks', $disk);
        }

        $data['user_id'] = $user->id;

        $logbook = Logbook::create($data + ['status' => Logbook::STATUS_PENDING]);

        return Redirect::route('mahasiswa.logbooks.index')->with('success', 'Logbook berhasil ditambahkan.');
    }

    public function destroy(Request $request, Logbook $logbook)
    {
        $user = $request->user();

        if ($logbook->user_id !== $user->id) {
            abort(403);
        }

        if ($logbook->status !== Logbook::STATUS_PENDING) {
            abort(403, 'Hanya entri dengan status pending yang dapat dihapus.');
        }

        if ($logbook->foto_kegiatan_path) {
            try {
                $disk = config('filesystems.default');
                Storage::disk($disk)->delete($logbook->foto_kegiatan_path);
            } catch (\Exception $e) {
                // ignore
            }
        }

        $logbook->delete();

        return Redirect::route('mahasiswa.logbooks.index')->with('success', 'Logbook berhasil dihapus.');
    }
}
