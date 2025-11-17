<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MitraDashboardController extends Controller
{
    /**
     * Show the mitra dashboard.
     */
    public function index(Request $request): View
    {
        return view('mitra-portal.dashboard');
    }
}
