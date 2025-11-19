<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use App\Models\Mitra;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        $totalUsers = User::count();
        $totalLowongan = Lowongan::count();
        $totalAplikasi = Aplikasi::count();
        $totalMitra = Mitra::count();
        return view('admin.dashboard', compact('totalUsers', 'totalLowongan', 'totalAplikasi', 'totalMitra'));
    }
}