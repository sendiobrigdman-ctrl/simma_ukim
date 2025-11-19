<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DemoController extends Controller
{
    public function index()
    {
        // show a simple developer demo page with seeded accounts
        $users = User::whereIn('role', ['admin', 'mitra', 'mahasiswa'])->get()->groupBy('role');
        return view('demo.index', ['users' => $users]);
    }

    /**
     * Login as demo user (POST) - this bypasses password checks for convenience in local/demo only.
     */
    public function loginAs(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->firstOrFail();

        auth()->login($user);

        return redirect()->intended('/dashboard');
    }
}
