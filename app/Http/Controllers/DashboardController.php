<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use App\Models\Logbook;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $data = [
                'totalUsers' => User::count(),
                'totalCompanies' => User::where('role', 'mitra')->count(),
                'pendingLowongan' => Lowongan::where('status', Lowongan::STATUS_PENDING)->count(),
            ];

            return view('admin.dashboard', $data);
        }

        if ($user->role === 'mitra') {
            $activeJobs = Lowongan::where('mitra_id', $user->id)->where('status', Lowongan::STATUS_APPROVED)->count();

            $newApplicants = Aplikasi::whereHas('lowongan', function ($q) use ($user) {
                $q->where('mitra_id', $user->id);
            })->where('status_aplikasi', 'pending')->count();

            $acceptedStudentIds = Aplikasi::whereHas('lowongan', function ($q) use ($user) {
                $q->where('mitra_id', $user->id);
            })->where('status_aplikasi', 'diterima_mitra')->pluck('user_id')->toArray();

            $unverifiedLogbooks = Logbook::whereIn('user_id', $acceptedStudentIds)->where('status', Logbook::STATUS_PENDING)->count();

            return view('mitra.dashboard', compact('activeJobs', 'newApplicants', 'unverifiedLogbooks'));
        }

        // Mahasiswa
        $activeApplications = Aplikasi::where('user_id', $user->id)->count();
        $todaysLogbooks = Logbook::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->count();

        return view('mahasiswa.dashboard', compact('activeApplications', 'todaysLogbooks'));
    }
}
