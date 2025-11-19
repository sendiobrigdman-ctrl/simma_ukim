@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Developer Demo — Quick Role Switch</h1>
        <p class="text-sm text-gray-600 mb-6">Use these demo accounts to quickly switch roles during presentations.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border rounded p-4 bg-gray-50">
                <h2 class="font-semibold">Admin</h2>
                @if(isset($users['admin']))
                    @foreach($users['admin'] as $u)
                        <p class="text-sm">Email: <strong>{{ $u->email }}</strong></p>
                        <p class="text-sm">Password: <strong>password</strong></p>
                        <form method="POST" action="{{ route('demo.login') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $u->email }}">
                            <button class="mt-2 inline-block px-3 py-2 bg-blue-600 text-white rounded">Login as Admin</button>
                        </form>
                    @endforeach
                @endif
            </div>

            <div class="border rounded p-4 bg-gray-50">
                <h2 class="font-semibold">Mitra</h2>
                @if(isset($users['mitra']))
                    @foreach($users['mitra'] as $u)
                        <p class="text-sm">Email: <strong>{{ $u->email }}</strong></p>
                        <p class="text-sm">Password: <strong>password</strong></p>
                        <form method="POST" action="{{ route('demo.login') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $u->email }}">
                            <button class="mt-2 inline-block px-3 py-2 bg-green-600 text-white rounded">Login as Mitra</button>
                        </form>
                    @endforeach
                @endif
            </div>

            <div class="border rounded p-4 bg-gray-50">
                <h2 class="font-semibold">Mahasiswa</h2>
                @if(isset($users['mahasiswa']))
                    @foreach($users['mahasiswa'] as $u)
                        <p class="text-sm">Email: <strong>{{ $u->email }}</strong></p>
                        <p class="text-sm">Password: <strong>password</strong></p>
                        <form method="POST" action="{{ route('demo.login') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $u->email }}">
                            <button class="mt-2 inline-block px-3 py-2 bg-indigo-600 text-white rounded">Login as Mahasiswa</button>
                        </form>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="mt-6 border-t pt-4">
            <a href="/" class="text-blue-600 mr-4">Landing</a>
            <a href="/login" class="text-blue-600 mr-4">Login</a>
            <a href="/register" class="text-blue-600">Register</a>
        </div>
    </div>
</div>
@endsection
