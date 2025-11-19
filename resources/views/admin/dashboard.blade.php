@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Total Pengguna</div>
            <div class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Total Lowongan</div>
            <div class="text-2xl font-bold">{{ $totalLowongan ?? 0 }}</div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Total Aplikasi</div>
            <div class="text-2xl font-bold">{{ $totalAplikasi ?? 0 }}</div>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <div class="text-sm text-gray-500">Total Mitra</div>
            <div class="text-2xl font-bold">{{ $totalMitra ?? 0 }}</div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="display-4">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Lowongan</h5>
                    <p class="display-4">{{ $totalLowongan ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Aplikasi</h5>
                    <p class="display-4">{{ $totalAplikasi ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Mitra</h5>
                    <p class="display-4">{{ $totalMitra ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
